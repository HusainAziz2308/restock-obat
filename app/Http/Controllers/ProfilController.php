<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    private array $mahasiswa = [
        [
            'nama' => 'Nukhi Alvin Rahmahdani',
            'nim' => '4124044',
            'program_studi' => 'Sistem Informasi',
            'semester' => '4',
            'keahlian' => [
                'Desain Basis Data',
                'HTML'
            ],
            'jabatan' => 'Anggota Tim',
            'status' => 'Mahasiswa Aktif',
            'foto' => 'nukhi.jpeg'
        ],
        [
            'nama' => 'Husain Aziz Al Rosyid, CEE',
            'nim' => '4124031',
            'program_studi' => 'Sistem Informasi',
            'semester' => '4',
            'keahlian' => [
                'Pemrograman Web',
                'Desain UI/UX',
                'Github Project Management',
                'Jaringan Komputer'
            ],
            'jabatan' => 'Ketua Tim',
            'status' => 'Mahasiswa Aktif',
            'foto' => 'husain.png'
        ],
        [
            'nama' => 'Affani Yusuf',
            'nim' => '4119064',
            'program_studi' => 'Sistem Informasi',
            'semester' => '14',
            'keahlian' => [
                'Pemrograman Web',
                'Basis Data',
                'Jaringan Komputer'
            ],
            'jabatan' => 'Anggota Tim',
            'status' => 'Mahasiswa Aktif',
            'foto' => 'affani.jpg'
        ]
    ];

    /**
     * Menampilkan halaman daftar tim developer.
     */
    public function index()
    {
        $mahasiswa = $this->mahasiswa;

        return view('about', compact('mahasiswa'));
    }

    /**
     * Menampilkan detail profil mahasiswa berdasarkan NIM.
     */
    public function show($nim)
    {
        foreach ($this->mahasiswa as $mhs) {
            if ($mhs['nim'] == $nim) {
                return view('detail_profil', ['mahasiswa' => $mhs]);
            }
        }

        abort(404);
    }
}
