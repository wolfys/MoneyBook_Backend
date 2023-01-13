<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Handbook\ExpendCategories;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
        Gate::define('update-categories', static function (User $user, ExpendCategories $categories) {
            return $user->id === $categories->user_id;
        });
    }
}
