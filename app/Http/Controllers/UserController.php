<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationRepositoryInterface;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    private ReservationRepositoryInterface $reservationRepository;

    /**
     * UserController constructor.
     *
     * @param ReservationRepositoryInterface $reservationRepository
     */
    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
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
}
