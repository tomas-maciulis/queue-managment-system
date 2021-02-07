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
                                <h1 class="mx-auto mb-0 display-4">{{ $reservation->code }}</h1>
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
                                    <button type="button" class="btn btn-danger btn-md float-right mt-4 col-xl-3 col-lg-4 col-md-5" data-toggle="modal" data-target="#confirmCancellationModal">
                                        Cancel reservation
                                    </button>
                                </div>

                                <div class="modal fade" id="confirmCancellationModal" tabindex="-1" role="dialog" aria-labelledby="confirmCancellationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="confirmCancellationModalLabel">Are you sure?</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5>Are you sure you want to cancel the reservation?<br> This process cannot be undone.</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal">No</button>
                                                <form method="POST" action="{{ route('reservation.cancel', $reservation->slug) }}">
                                                    @csrf
                                                    <button class="btn btn-danger btn-lg float-right">Yes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
