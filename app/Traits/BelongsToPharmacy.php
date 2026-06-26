<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToPharmacy
{
    protected static function bootBelongsToPharmacy()
    {
        // Otomatis tambahkan WHERE pharmacy_id = user->pharmacy_id saat query
        static::addGlobalScope('pharmacy', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('pharmacy_id', Auth::user()->pharmacy_id);
            }
        });

        // Otomatis isi pharmacy_id saat data dibuat
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->pharmacy_id = Auth::user()->pharmacy_id;
            }
        });
    }
}