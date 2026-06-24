<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicePackage;
use Spatie\LaravelPackageTools\Package;

class KatalogController extends Controller
{
    public function index()
    {
        $rawPackages = ServicePackage::all()->toArray();
        
        $packages = [];
        foreach ($rawPackages as $package) {
            if (is_string($package['original_price']) && !is_numeric($package['original_price'])) {
                $package['price'] = $package['original_price'];
                $package['original_price'] = null;
                $package['discount'] = null;
            } elseif ($package['discount_percent'] > 0) {
                $discountAmount = ($package['original_price'] * $package['discount_percent']) / 100;
                $finalPrice = $package['original_price'] - $discountAmount;

                $package['price'] = 'Rp ' . ($finalPrice / 1000) . 'k';
                $package['original_price'] = 'Rp ' . ($package['original_price'] / 1000) . 'k';
                $package['discount'] = 'Diskon ' . $package['discount_percent'] . '%';
            } else {
                $package['price'] = 'Rp ' . ($package['original_price'] / 1000) . 'k';
                $package['original_price'] = null;
                $package['discount'] = null;
            }
            $packages[] = $package;
        }
        return view('katalog', compact('packages'));
    }
}
