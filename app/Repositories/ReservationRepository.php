<?php

namespace App\Repositories;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ReservationRepository implements ReservationRepositoryInterface
{
    /**
     * Create a new reservation.
     *
     * @param StoreReservationRequest $request
     * @return Reservation
     */
    public function create(StoreReservationRequest $request): Reservation
    {
        $isSlugUnique = False;
        while (!$isSlugUnique) {
            $slug = substr(md5(microtime().mt_rand()), 0, 24);
            if (!Reservation::where('slug', $slug)->count()) {
                $isSlugUnique = True;
            }
        }

        $lastValidReservation = Reservation::where('user_id', '=', $request->user_id)
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'finished')
            ->orderByDesc('start_at')
            ->value('start_at');

        if ($lastValidReservation <= Carbon::now()) {
            $queueLength = Reservation::where('user_id', '=', $request->user_id)
                ->where('status', '!=', 'cancelled')
                ->where('status', '!=', 'finished')
                ->count();

            $lastValidReservation = Carbon::now()
                ->addMinutes(
                    config('app.visit_duration') * ($queueLength - 1)
                );
        }

        $startAt = $lastValidReservation
            ? $lastValidReservation
                ->addMinutes(config('app.visit_duration'))
            : Carbon::now();

        $reservation = new Reservation(request()->all());
        $reservation->slug = $slug;
        $reservation->status = 'received';
        $reservation->start_at = $startAt;
        $reservation->save();

        return $reservation;
    }

    /**
     * Get all reservations matching the criteria.
     *
     * @param int|null $userId get reservations for specific user by ID.
     * @param string|string[] $status return only reservations with specific status.
     * @param int|null $limit how many records should be returned.
     *
     * @return Collection
     */
    public function all(int $userId = null, $status = '', $limit = 50): Collection
    {
        if ($userId) {
            $reservations = Reservation::where('user_id', '=', $userId);
        } else {
            $reservations = Reservation::class;
        }

        if ($status) {
            if (gettype($status) === 'array') {
                $reservations = $reservations->whereIn('status', $status);
                $reservations = $reservations->take($limit);
            } elseif (gettype($status) === 'string') {
                $reservations = Reservation::where('status', $status)->take($limit);
            }
        } else {
            $reservations = Reservation::take($limit);
        }

        return $reservations->get();
    }

    /**
     * @param string $reservationSlug
     * @return Reservation
     */
    public function findBySlug(string $reservationSlug): Reservation
    {
        return Reservation::where('slug', $reservationSlug)->firstOrFail();
    }

    /**
     * @param int $reservationId
     * @return Reservation
     */
    public function find(int $reservationId): Reservation
    {
        return Reservation::findOrFail($reservationId);
    }

    /**
     * @param string $reservationSlug
     * @return void
     */
    public function cancelVisitBySlug(string $reservationSlug): void
    {
        $reservation = Reservation::where('slug', $reservationSlug)->firstOrFail();
        $reservation->status = 'cancelled';
        $reservation->save();
    }

    /**
     * @param int $reservationId
     * @return void
     */
    public function cancelVisitById(int $reservationId): void
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->status = 'cancelled';
        $reservation->save();
    }

    /**
     * @param int $reservationId
     * @return void
     */
    public function beginVisit(int $reservationId): void
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->status = 'in progress';
        $reservation->save();
    }

    /**
     * @param int $reservationId
     * @return void
     */
    public function finishVisit(int $reservationId): void
    {
        $reservation = Reservation::findOrFail($reservationId);
        $reservation->status = 'finished';
        $reservation->save();
    }
}
