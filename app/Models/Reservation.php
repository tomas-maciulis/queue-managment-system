<?php

namespace App\Models;

use Carbon\Carbon;
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
    protected $fillable = [
        'user_id',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'start_at' => 'datetime',
    ];

    /**
     * Get the human readable time left until start of the visit.
     *
     * @return string
     */
    public function getTimeUntilAttribute(): string
    {
        $currentTime = Carbon::now();
        if ($currentTime >= $this->start_at) {
            return '0 hours 0 minutes';
        }

        $timeDiff = $currentTime->diff($this->start_at, false);
        if ($timeDiff->format('%h') == 1) {
            $format = '%h hour';
        } else {
            $format = '%h hours';
        }

        if ($timeDiff->format('%i') == 1) {
            $format .= ' %i minute';
        } else {
            $format .= ' %i minutes';
        }

        return $timeDiff->format($format);
    }

    /**
     * Get the user that got assigned the reservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
