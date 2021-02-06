@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reservation information</div>
                    <div class="card-body">
                        <div class="d-flex flex-column justify-content-center bd-highlight mb-3">
                            <h1 class="mx-auto mb-0 display-4">{{ $reservation->code }}</h1>
                            <h5 class="mx-auto mt-0">code</h5>
                            <span class="border-bottom mb-1"></span>

                            <h3 class="mx-auto mb-0">{{ $reservation->user->room }}</h3>
                            <h6 class="mx-auto mt-0">room</h6>
                            <span class="border-bottom"></span>

                            <h3 class="mx-auto mb-0">{{ $reservation->user->full_name }}</h3>
                            <h6 class="mx-auto mt-0">specialist</h6>
                            <span class="border-bottom"></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
