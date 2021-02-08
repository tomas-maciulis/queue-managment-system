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
     * @return Reservation
     */
    public function findBySlug(string $reservationSlug): Reservation;

    /**
     * @param int $reservationId
     * @return Reservation
     */
    public function find(int $reservationId): Reservation;

    /**
     * @param string $reservationSlug
     * @return void
     */
    public function cancelVisitBySlug(string $reservationSlug): void;

    /**
     * @param int $reservationId
     * @return void
     */
    public function cancelVisitById(int $reservationId): void;


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
