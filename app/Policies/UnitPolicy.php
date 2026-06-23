<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Semua role bisa melihat daftar unit
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker', 'Pegawai']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Unit $unit): bool
    {
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker', 'Pegawai']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Pegawai biasa tidak boleh menambah master unit baru
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Unit $unit): bool
    {
        return $user->hasAnyRole(['Owner', 'Manager', 'Apoteker']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Unit $unit): bool
    {
        // Hanya Owner dan Manager yang bisa menghapus data unit dari sistem
        return $user->hasAnyRole(['Owner', 'Manager']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Unit $unit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Unit $unit): bool
    {
        return false;
    }
}
