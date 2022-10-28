<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isEditor', function($user) {
            return $user->editor == true; 
        });
        
        Gate::define('notPart', function($user) {
            return $user->role_id != 3;
        });
        
        Gate::define('isFirstRegist', function($user) {
           return empty(User::whereNotNull('editor')->first());
        });
    }
}
