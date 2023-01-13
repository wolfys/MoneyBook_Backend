<?php

namespace App\Providers;

use App\Models\ExpendCategories;
use App\Models\ExpendTransactions;
use App\Models\IncomeCategories;
use App\Models\IncomeTransactions;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('expend-categories', static function (User $user, ExpendCategories $categories) {
            return $user->id === $categories->user_id;
        });

        Gate::define('income-categories', static function (User $user, IncomeCategories $categories) {
            return $user->id === $categories->user_id;
        });

        Gate::define('expend-transactions', static function (User $user, ExpendTransactions $transactions) {
            return $user->id === $transactions->user_id;
        });

        Gate::define('income-transactions', static function (User $user, IncomeTransactions $transactions) {
            return $user->id === $transactions->user_id;
        });

    }
}
