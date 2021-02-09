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
     * Get all reservations matching the criteria.
     *
     * @param int $limit how many records should be returned.
     * @param int|null $userId get reservations for specific user by ID.
     * @param string|string[] $status return only reservations with specific status.
     *
     * @return Collection
     */
    public function all(int $userId = null, $status = '', $limit = 50): Collection;

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
