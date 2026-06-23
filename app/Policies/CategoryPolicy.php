<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Semua role bisa melihat kategori obat
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker', 'Pegawai']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker', 'Pegawai']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Pegawai biasa tidak boleh menambah master kategori baru
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        // Hanya Owner dan Manager yang bisa menghapus data kategori dari sistem
        return $user->hasAnyRole(['Owner', 'Manager']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $category): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return false;
    }
}
