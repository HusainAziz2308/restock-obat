<?php

namespace App\Policies;

use App\Models\Restock;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RestockPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public static function canAccess(User $user): bool
    {
        return $user->hasAnyRole(['Owner', 'Manager']);
    }

    public function viewAny(User $user): bool
    {
        // Hanya Owner dan Manager yang bisa melihat menu dan daftar transaksi
        return $user->hasAnyRole(['Owner', 'Manager']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restock $restock): bool
    {
        return $user->hasAnyRole(['Owner', 'Manager']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Pegawai justru HARUS bisa mencatat restock masuk
        return $user->hasAnyRole(['Owner', 'Manager']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restock $restock): bool
    {
        // Transaksi yang sudah masuk biasanya tidak boleh sembarang diedit pegawai biasa
        return $user->hasAnyRole(['Owner', 'Manager']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restock $restock): bool
    {
        // Hanya Owner yang boleh menghapus riwayat transaksi demi keamanan finansial
        return $user->hasRole('Owner');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Restock $restock): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Restock $restock): bool
    {
        return false;
    }
}
