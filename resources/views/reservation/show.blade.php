@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reservation information</div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center bd-highlight mb-3">
                            @if ($reservation->status === 'received')
                                <h1 class="mx-auto mb-0 display-4">{{ $reservation->id }}</h1>
                                <h5 class="mx-auto mt-0">code</h5>
                                <span class="border-bottom mb-1"></span>
                            @else
                                <h2 class="mx-auto mb-0">Reservation is {{ $reservation->status }}</h2>
                                <span class="border-bottom mb-1"></span>
                            @endif

                            <h3 class="mx-auto mb-0 mt-2">{{ $reservation->user->room }}</h3>
                            <h6 class="mx-auto mt-0">room</h6>
                            <span class="border-bottom"></span>

                            <h4 class="mx-auto mb-0 mt-2">{{ $reservation->user->full_name }}</h4>
                            <h6 class="mx-auto mt-0">specialist</h6>
                            <span class="border-bottom"></span>

                            @if ($reservation->status === 'received')
                                <h3 class="mx-auto mb-0 mt-2">{{ $reservation->time_until }}</h3>
                                <h6 class="mx-auto mt-0">approximate time left until your visit</h6>
                                <span class="border-bottom"></span>
                            @endif

                            @if ($reservation->status === 'received')
                                <div class="text-right">
                                    <button type="button" class="btn btn-danger btn-md float-right mt-4 col-xl-3 col-lg-4 col-md-5" data-toggle="modal" data-target="#confirmCancellationModal-{{ $reservation->id }}">
                                        Cancel reservation
                                    </button>
                                </div>

                                @include('reservation.include._cancel_reservation_modal', ['id' => $reservation->id ,'action' => route('reservation.cancel_by_slug', $reservation->slug)])
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
