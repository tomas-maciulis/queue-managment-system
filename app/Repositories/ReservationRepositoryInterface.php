<?php

namespace App\Repositories;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ReservationRepositoryInterface
{
    /**
     * Create a new reservation.
     *
     * @param StoreReservationRequest $request
     * @return Reservation
     */
    public function create(StoreReservationRequest $request): Reservation;

    /**
     * @return Reservation[]|Collection
     */
    public function all();

    /**
     * @param string $reservationSlug
     * @return Reservation|Model
     */
    public function findBySlug(string $reservationSlug);

    /**
     * @param string $reservationSlug
     * @return void
     */
    public function cancelVisitByReservee(string $reservationSlug): void;

    /**
     * @param int $reservationId
     * @return void
     */
    public function cancelVisitByUser(int $reservationId): void;

    /**
     * @param int $reservationId
     * @return void
     */
    public function acceptVisit(int $reservationId): void;

    /**
     * @param int $reservationId
     * @return void
     */
    public function beginVisit(int $reservationId): void;

    /**
     * @param int $reservationId
     * @return void
     */
    public function finishVisit(int $reservationId): void;
}
