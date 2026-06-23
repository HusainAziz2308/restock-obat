<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'slug', 'description', 'company_id'];

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (blank($category->company_id) && Auth::check() && Auth::user()->company_id) {
                $category->company_id = Auth::user()->company_id;
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
}
