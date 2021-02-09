<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Repositories\ReservationRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
     * Cancel a reservation by slug.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function cancelBySlug(Request $request): RedirectResponse
    {
        $this->reservationRepository->cancelVisitBySlug($request->slug);

        return redirect(route('home'));
    }

    /**
     * Cancel a reservation by id.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function cancelById(Request $request): RedirectResponse
    {
        $reservation = $this->reservationRepository->find(intval($request->id));
        $this->authorize('update', $reservation);

        $this->reservationRepository->cancelVisitById(intval($request->id));

        return redirect(route('home'));
    }

    /**
     * Begin the visit.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function begin(Request $request): RedirectResponse
    {
        $reservation = $this->reservationRepository->find(intval($request->id));
        $this->authorize('update', $reservation);

        if (! Gate::allows('begin-visit')) {
            return redirect()->back()->withErrors(['visit' => 'You must finish the current visit to start a new one.']);
        }

        $this->reservationRepository->beginVisit(intval($request->id));

        return redirect(route('home'));
    }

    /**
     * Begin the visit.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function finish(Request $request): RedirectResponse
    {
        $reservation = $this->reservationRepository->find(intval($request->id));
        $this->authorize('update', $reservation);

        $this->reservationRepository->finishVisit(intval($request->id));

        return redirect(route('home'));
    }
}
