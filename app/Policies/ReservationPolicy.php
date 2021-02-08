<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;


class ReservationPolicy
{
    /**
     * Check if user is authorized to cancel the reservation.
     *
     * @param User $user
     * @param Reservation $reservation
     * @return bool
     */
    public function update(User $user, Reservation $reservation): bool
    {
        return $user->reservations->contains($reservation);
    }
}
