<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'amount',
        'reason',
        'status',
        'payment_proof_path' // Pastikan ini ditambahkan
    ];

    /**
     * Get the booking that owns the fine.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}