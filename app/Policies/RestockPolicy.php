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
    public function viewAny(User $user): bool
    {
        // Admin dan Kasir bisa melihat daftar pembelian
        return $user->role === 'admin' || $user->role === 'kasir';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Restock $restock): bool
    {
        // Admin dan Kasir bisa melihat detail pembelian
        return $user->role === 'admin' || $user->role === 'kasir';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Admin dan Kasir bisa membuat pembelian baru
        return $user->role === 'admin' || $user->role === 'kasir';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restock $restock): bool
    {
        // Hanya Admin yang bisa mengedit pembelian
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restock $restock): bool
    {
        // Hanya Admin yang bisa menghapus pembelian
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Restock $restock): bool
    {
        // Hanya Admin yang bisa mengembalikan pembelian yang dihapus
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Restock $restock): bool
    {
        // Hanya Admin yang bisa menghapus permanen pembelian
        return $user->role === 'admin';
    }
}
