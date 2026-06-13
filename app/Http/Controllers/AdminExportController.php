<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Restock;
use App\Models\StockMovement;
use App\Models\StockOut;
use Illuminate\Http\Response;

class AdminExportController extends Controller
{
    public function medicines(): Response
    {
        $rows = Medicine::with(['category', 'unit'])
            ->orderBy('name')
            ->get()
            ->map(fn (Medicine $m) => [
                $m->code,
                $m->name,
                $m->category?->name ?? '-',
                $m->unit?->name ?? '-',
                'Rp ' . number_format((float) $m->price, 0, ',', '.'),
                $m->stock,
                $m->min_stock,
                $m->stock_status,
                $m->expired_date?->format('d-m-Y') ?? '-',
            ])->all();

        return $this->excel(
            'laporan-obat',
            'Laporan Data Obat',
            ['Kode', 'Nama Obat', 'Kategori', 'Satuan', 'Harga Jual', 'Stok', 'Stok Min.', 'Status', 'Kedaluwarsa'],
            $rows,
            ['right', 'left', 'left', 'left', 'right', 'right', 'right', 'center', 'center'],
        );
    }

    public function restocks(): Response
    {
        $rows = Restock::with(['medicine', 'supplier', 'creator'])
            ->latest('restock_date')
            ->get()
            ->map(fn (Restock $r) => [
                $r->restock_date?->format('d-m-Y') ?? '-',
                $r->medicine?->code ?? '-',
                $r->medicine?->name ?? '-',
                $r->supplier?->name ?? '-',
                $r->quantity,
                'Rp ' . number_format((float) $r->cost_price, 0, ',', '.'),
                'Rp ' . number_format((float) $r->total_cost, 0, ',', '.'),
                $r->note ?? '-',
                $r->creator?->name ?? '-',
            ])->all();

        $total = (float) Restock::sum('total_cost');
        $totalQty = (int) Restock::sum('quantity');

        return $this->excel(
            'laporan-restock',
            'Laporan Restock / Pembelian',
            ['Tanggal', 'Kode Obat', 'Nama Obat', 'Supplier', 'Qty', 'Harga Beli', 'Total Beli', 'Catatan', 'Dibuat Oleh'],
            $rows,
            ['center', 'right', 'left', 'left', 'right', 'right', 'right', 'left', 'left'],
            [
                'Total Qty Masuk' => (string) $totalQty,
                'Total Pembelian' => 'Rp ' . number_format($total, 0, ',', '.'),
            ],
        );
    }

    public function stockOuts(): Response
    {
        $rows = StockOut::with(['medicine', 'creator'])
            ->latest('out_date')
            ->get()
            ->map(fn (StockOut $s) => [
                $s->out_date?->format('d-m-Y') ?? '-',
                $s->medicine?->code ?? '-',
                $s->medicine?->name ?? '-',
                $s->quantity,
                $s->reason,
                $s->note ?? '-',
                $s->creator?->name ?? '-',
            ])->all();

        $totalQty = (int) StockOut::sum('quantity');

        return $this->excel(
            'laporan-barang-keluar',
            'Laporan Barang Keluar',
            ['Tanggal', 'Kode Obat', 'Nama Obat', 'Qty', 'Alasan', 'Catatan', 'Dibuat Oleh'],
            $rows,
            ['center', 'right', 'left', 'right', 'left', 'left', 'left'],
            ['Total Qty Keluar' => (string) $totalQty],
        );
    }

    public function stockMovements(): Response
    {
        $rows = StockMovement::with(['medicine', 'creator'])
            ->latest()
            ->get()
            ->map(fn (StockMovement $m) => [
                $m->created_at?->format('d-m-Y H:i') ?? '-',
                $m->medicine?->code ?? '-',
                $m->medicine?->name ?? '-',
                StockMovement::TYPES[$m->type] ?? $m->type,
                $m->quantity,
                $m->before_stock,
                $m->after_stock,
                $m->note ?? '-',
                $m->creator?->name ?? '-',
            ])->all();

        return $this->excel(
            'laporan-mutasi-stok',
            'Laporan Mutasi Stok',
            ['Waktu', 'Kode Obat', 'Nama Obat', 'Tipe', 'Qty', 'Sebelum', 'Sesudah', 'Catatan', 'Dibuat Oleh'],
            $rows,
            ['center', 'right', 'left', 'center', 'right', 'right', 'right', 'left', 'left'],
        );
    }

    /**
     * Stream a styled HTML-as-Excel (.xls) document. Excel reads HTML tables natively
     * and applies inline CSS, so we get themed exports without extra packages.
     */
    private function excel(string $slug, string $title, array $headers, array $rows, array $aligns = [], array $summary = []): Response
    {
        $companyName = optional(auth()->user()?->company)->name ?? 'Apotek';
        $generatedAt = now()->translatedFormat('d F Y, H:i');
        $colspan = count($headers);

        $html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>';
        $html .= '<style>
            table { border-collapse: collapse; font-family: Calibri, Arial, sans-serif; font-size: 11pt; }
            .title { font-size: 16pt; font-weight: bold; color: #1f2937; }
            .subtitle { font-size: 10pt; color: #6b7280; }
            .meta { font-size: 9pt; color: #9ca3af; }
            th { background-color: #f59e0b; color: #ffffff; font-weight: bold; padding: 8px 10px; border: 1px solid #d97706; text-align: center; }
            td { padding: 6px 10px; border: 1px solid #e5e7eb; vertical-align: middle; }
            tr.even td { background-color: #fffbeb; }
            tr.odd td { background-color: #ffffff; }
            .summary-label { background-color: #fef3c7; font-weight: bold; color: #78350f; text-align: right; padding: 8px 10px; border: 1px solid #f59e0b; }
            .summary-value { background-color: #fde68a; font-weight: bold; color: #78350f; text-align: right; padding: 8px 10px; border: 1px solid #f59e0b; }
        </style>';

        // Header block
        $html .= '<table><tr><td class="title" colspan="' . $colspan . '">' . e($title) . '</td></tr>';
        $html .= '<tr><td class="subtitle" colspan="' . $colspan . '">' . e($companyName) . '</td></tr>';
        $html .= '<tr><td class="meta" colspan="' . $colspan . '">Dibuat: ' . e($generatedAt) . '</td></tr>';
        $html .= '<tr><td colspan="' . $colspan . '">&nbsp;</td></tr></table>';

        // Data table
        $html .= '<table>';
        $html .= '<thead><tr>';
        foreach ($headers as $h) {
            $html .= '<th>' . e($h) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        if (empty($rows)) {
            $html .= '<tr><td colspan="' . $colspan . '" style="text-align:center;color:#9ca3af;">Tidak ada data</td></tr>';
        } else {
            foreach ($rows as $i => $row) {
                $cls = $i % 2 === 0 ? 'odd' : 'even';
                $html .= '<tr class="' . $cls . '">';
                foreach ($row as $j => $cell) {
                    $align = $aligns[$j] ?? 'left';
                    $html .= '<td style="text-align:' . $align . ';">' . e((string) $cell) . '</td>';
                }
                $html .= '</tr>';
            }
        }

        $html .= '</tbody>';

        if (! empty($summary)) {
            foreach ($summary as $label => $value) {
                $labelSpan = $colspan - 1;
                $html .= '<tr><td class="summary-label" colspan="' . $labelSpan . '">' . e($label) . '</td>';
                $html .= '<td class="summary-value">' . e($value) . '</td></tr>';
            }
        }

        $html .= '</table></body></html>';

        $filename = $slug . '-' . now()->format('Ymd-His') . '.xls';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }
}
