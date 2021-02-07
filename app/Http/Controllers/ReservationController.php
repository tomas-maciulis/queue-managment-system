<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Repositories\ReservationRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private ReservationRepositoryInterface $reservationRepository;
    private UserRepositoryInterface $userRepository;

    /**
     * ReservationController constructor.
     *
     * @param ReservationRepositoryInterface $reservationRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        ReservationRepositoryInterface $reservationRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->reservationRepository = $reservationRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new reservation.
     *
     * @return View
     */
    public function create(): View
    {
        $users = $this->userRepository->available();

        return view('reservation.create')->with(['users' => $users]);
    }

    /**
     * Store a reservation.
     *
     * @param StoreReservationRequest $request
     * @return RedirectResponse
     */
    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $reservation = $this->reservationRepository->create($request);

        return redirect(route('reservation.show', $reservation->slug));
    }

    /**
     * Show a reservation.
     *
     * @param Request $request
     * @return View
     */
    public function show(Request $request): View
    {
        $reservation = $this->reservationRepository->findBySlug($request->slug);

        return view('reservation.show')->with(['reservation' => $reservation]);
    }

    /**
     * Cancel a reservation.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function cancel(Request $request): RedirectResponse
    {
        $this->reservationRepository->cancelVisitByReservee($request->slug);

        return redirect('/');
    }
}
