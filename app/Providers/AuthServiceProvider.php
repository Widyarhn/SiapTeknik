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
    public function boot()
    {
        $this->registerPolicies();

        Gate::define("Asesor", function (User $user) {
            if (empty($user->role_id)) {
                return redirect("/logout");
            } else {
                return $user->role_id == "1";
            }
        });
        Gate::define("Prodi", function (User $user) {
            if (empty($user->role_id)) {
                return redirect("/logout");
            } else {
                return $user->role_id == "2";
            }
        });
        Gate::define("UPPS", function ($user) {
            if (empty($user->role_id)) {
                return redirect("/logout");
            } else {
                return $user->role_id == "3";
            }
        });
    }
        // public function boot() : void
    // {
    //     $this->registerPolicies();

    //     Gate::define("Asesor", function (User $user){
    //         if ($user->role_id == 1){
    //             return true;
    //         }
    //         return false;
    //     });

    //     Gate::define("Prodi", function (User $user){
    //         if ($user->role_id == 2){
    //             return true;
    //         }
    //         return false;
    //     });

    //     Gate::define("UPPS", function (User $user){
    //         if ($user->role_id == 3){
    //             return true;
    //         }
    //         return false;
    //     });
    // }
    
}
