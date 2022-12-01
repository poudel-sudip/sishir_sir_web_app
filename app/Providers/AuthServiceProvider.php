<?php

namespace App\Providers;

use App\Models\Batch;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        //Gates
        Gate::define('classroom',function (User $user,Batch $batch)
        {
            $user=Auth::user();
            if($user->role == 'Admin')
            {
                return true;
            }
            $booking = Booking::where([['batch_id','=',$batch->id],['user_id','=',$user->id]])->first();
            if($booking)
            {
                if($booking->status == 'Verified' && $booking->suspended == false)
                {
                    return true;
                }
            }
        });

    }
}
