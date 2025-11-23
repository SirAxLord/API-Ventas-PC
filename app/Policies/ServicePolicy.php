<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Services;

class ServicePolicy
{
    public function before(?User $user, string $ability): ?bool
    {
        if ($user && $user->role === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Services $service): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Services $service): bool
    {
        return false;
    }

    public function delete(User $user, Services $service): bool
    {
        return false;
    }
}
