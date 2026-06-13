<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'contact_person',
        'notes',
        'company_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (Supplier $supplier) {
            if (blank($supplier->company_id) && Auth::check() && Auth::user()->company_id) {
                $supplier->company_id = Auth::user()->company_id;
            }
        });

        static::addGlobalScope('company', function (Builder $builder) {
            if (Auth::check() && Auth::user()->company_id) {
                $builder->where('company_id', Auth::user()->company_id);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function restocks()
    {
        return $this->hasMany(Restock::class);
    }
}
