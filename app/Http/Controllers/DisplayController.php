<?php

namespace App\Http\Controllers;

use App\Repositories\ReservationRepositoryInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    private ReservationRepositoryInterface $reservationRepository;

    /**
     * DisplayController constructor.
     *
     * @param ReservationRepositoryInterface $reservationRepository
     */
    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Show the display or get reservation data via AJAX.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function show(Request $request)
    {
        $reservationsReceived =
            $this->reservationRepository
                ->all(null, 'received', 10)
                ->sortBy('start_at');

        foreach($reservationsReceived as $reservation) {
            $reservation->room = $reservation->user->room;
        }

        $reservationsInProgress =
            $this->reservationRepository
                ->all(null, 'in progress', 5);

        foreach($reservationsInProgress as $reservation) {
            $reservation->room = $reservation->user->room;
        }

        if($request->ajax()){
            return response()->json([
                'reservationsReceived' => $reservationsReceived,
                'reservationsInProgress' => $reservationsInProgress,
            ]);
        }

        return view('display.index');
    }
}
