<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Reservation Model.
 * @mixin Builder
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'user_id',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [
        'start_at' => 'datetime',
    ];

    /**
     * Get the user that got assigned the reservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
