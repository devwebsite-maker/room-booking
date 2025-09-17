<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Booking;      // <-- 1. PASTIKAN 'use App\Models\Booking;' ADA
use App\Policies\BookingPolicy;  // <-- 2. PASTIKAN 'use App\Policies\BookingPolicy;' ADA

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class => BookingPolicy::class, // <-- 3. PASTIKAN BARIS INI ADA DI DALAM ARRAY
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}