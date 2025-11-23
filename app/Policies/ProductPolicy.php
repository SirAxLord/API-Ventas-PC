<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Products;

class ProductPolicy
{
    public function before(?User $user, string $ability): ?bool
    {
        // Admin tiene acceso total a CRUD
        if ($user && $user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(?User $user): bool
    {
        return true; // listado público
    }

    public function view(?User $user, Products $product): bool
    {
        return true; // detalle público
    }

    public function create(User $user): bool
    {
        return false; // solo admin (capturado en before)
    }

    public function update(User $user, Products $product): bool
    {
        return false; // solo admin (before)
    }

    public function delete(User $user, Products $product): bool
    {
        return false; // solo admin (before)
    }
}
