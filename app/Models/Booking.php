<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'start_time',
        'end_time',
        'status',
        'payment_proof_path',
        'total_price',
    ];

    /**
     * Get the user that owns the booking.
     * Selalu ambil data user, meskipun user tersebut sudah di-soft-delete.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    
    /**
     * Get the room associated with the booking.
     * Selalu ambil data ruangan, meskipun ruangan tersebut sudah di-soft-delete.
     */
    public function room()
    {
        return $this->belongsTo(Room::class)->withTrashed();
    }
}
