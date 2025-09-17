<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Aturan Emas: Admin bisa melakukan segalanya.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    /**
     * Semua user boleh melihat halaman daftar booking.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * User hanya bisa melihat detail booking miliknya.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id;
    }

    /**
     * Semua user yang login boleh membuat booking.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * PERUBAHAN DI SINI:
     * HANYA ADMIN YANG BOLEH UPDATE BOOKING.
     */
    public function update(User $user, Booking $booking): bool
    {
        // Aturan 'before' sudah mengizinkan admin, jadi ini akan otomatis menolak user biasa.
        return false;
    }

    /**
     * User hanya bisa men-delete (cancel) booking miliknya JIKA statusnya masih 'pending'.
     */
    public function delete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id && $booking->status === 'pending';
    }

    /**
     * Hanya admin yang boleh restore.
     */
    public function restore(User $user, Booking $booking): bool
    {
        return false;
    }

    /**
     * Hanya admin yang boleh force delete.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        return false;
    }
}