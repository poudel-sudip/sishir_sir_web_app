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
            if($status=='Verified' || $user->role=='Admin' || $user->role=='Tutor')
            {
                return true;
            }
        });

        Gate::define('permission',function (User $user,$action)
        {
            $user=Auth::user();
            switch ($action) 
            {
                case 'user-crud':
                    if($user->permission>=30)
                    {
                        return true;
                    }
                    break;

                case 'course-crud':
                    if($user->permission>=20)
                    {
                        return true;
                    }
                    break;

                case 'booking-crud':
                    if($user->permission>=40)
                    {
                        return true;
                    }
                    break;
                
                case 'zoom':
                    if($user->permission>=30)
                    {
                        return true;
                    }
                    break;

                case 'slider':
                    if($user->permission>=20)
                    {
                        return true;
                    }
                    break;

                case 'testimonial':
                    if($user->permission>=20)
                    {
                        return true;
                    }
                    break;

                case 'tutor':
                    if($user->permission>=20)
                    {
                        return true;
                    }
                    break;

                case 'notification':
                    if($user->permission>=30)
                    {
                        return true;
                    }
                    break;

                case 'video':
                    if($user->permission>=20)
                    {
                        return true;
                    }
                    break;

                case 'blog':
                    if($user->permission>=20)
                    {
                        return true;
                    }
                    break;

                case 'enquiry':
                    if($user->permission>=20)
                    {
                        return true;
                    }
                    break;

                default:
                    return false;
                    break;
            }
        });
    }
}
