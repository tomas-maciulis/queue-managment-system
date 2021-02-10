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
            $slug = substr(md5(time()), 0, 24);
            if (!Reservation::where('slug', $slug)->count()) {
                $isSlugUnique = True;
            }
        }

        $isCodeAvailable = False;
        while (!$isCodeAvailable) {
            $code = substr(md5(time()), 0, 5);

            $reservationsWithDuplicateCode = Reservation::where('code', $code)->get();
            if ($reservationsWithDuplicateCode->count()) {
                $statuses = $reservationsWithDuplicateCode->pluck('status')->toArray();
                if (!array_intersect($statuses, ['in progress', 'received'])) {
                    $isCodeAvailable = True;
                }
            } else {
                $isCodeAvailable = True;
            }
        }

        $lastValidReservation = User::where('id', $request->user_id)
            ->first()
            ->reservations
            ->filter(function ($item) {
                return $item->status !== 'cancelled'
                    && $item->status !== 'finished';
            })
            ->sortByDesc('start_at')
            ->first();

        //TODO: make visit time configurable.
        $startAt = $lastValidReservation
            ? $lastValidReservation
                ->start_at
                ->addMinutes(config('app.visit_duration'))
            : Carbon::now();

        $reservation = new Reservation(request()->all());
        $reservation->slug = $slug;
        $reservation->code = $code;
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
