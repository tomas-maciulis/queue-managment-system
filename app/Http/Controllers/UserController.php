<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private ReservationRepositoryInterface $reservationRepository;
    private UserRepositoryInterface $userRepository;

    /**
     * UserController constructor.
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
     * Display user's landing page.
     *
     * @return View
     */
    public function index(): View
    {
        $reservations = $this->reservationRepository->all(
            intval(auth()->user()->id),
            ['in progress', 'received'],
            30)
        ->sortBy('start_at')
        ->sortBy('status');

        return view('user.index')
            ->with(['reservations' => $reservations]);
    }

    /**
     * Make current user available for reservations.
     *
     * @return RedirectResponse
     */
    public function becomeAvailable(): RedirectResponse
    {
        $userId = auth()->user()->id;
        $this->userRepository->makeAvailable(intval($userId));

        return redirect(route('home'));
    }

    /**
     * Make current user unavailable for reservations.
     *
     * @return RedirectResponse
     */
    public function becomeUnavailable(): RedirectResponse
    {
        $userId = auth()->user()->id;
        $this->userRepository->makeUnavailable(intval($userId));

        return redirect(route('home'));
    }
}
