<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Products;
use App\Models\Services;
use App\Policies\ProductPolicy;
use App\Policies\ServicePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Products::class => ProductPolicy::class,
        Services::class => ServicePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
