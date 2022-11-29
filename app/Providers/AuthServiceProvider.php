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
            $booking=Booking::all()->where('batch_id',$batch->id)->where('user_id',$user->id);
            $status='';
            foreach ($booking as $b)
            {
                $status =$b->status;
            }
            if($status=='Verified' || $user->role=='Admin')
            {
                return true;
            }
        });

    }
}
