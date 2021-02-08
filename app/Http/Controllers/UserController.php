<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * Display user's landing page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('user.index')
            ->with(['reservations' => auth()->user()->reservations->sortByDesc('start_at')]);
    }
}
