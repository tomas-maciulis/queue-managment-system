@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            {{ __('Dashboard') }}
                        </div>
                        <div class="col-6 text-right">
                            @if(Auth::user()->is_available)
                                <form method="POST" action="{{ route('status.unavailable') }}">
                                    @csrf
                                    <button class="btn btn-sm btn-danger mx-1">Become unavailable</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('status.available') }}">
                                    @csrf
                                    <button class="btn btn-sm btn-success mx-1">Become available</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($reservations->count())
                        <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Start at</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($isReservationInProgress = False)
                        @php($isReservationFirstInList = True)
                        @foreach($reservations as $reservation)
                            <tr>
                                <th scope="row">{{ $reservation->id }}</th>
                                <td>{{ $reservation->start_at }}</td>
                                <td>{{ $reservation->status }}</td>
                                <td>
                                    <div class="row float-right">
                                        @if ($reservation->status === 'in progress')
                                            @php($isReservationInProgress = True)
                                            <form method="POST" action="{{ route('reservation.finish', $reservation->id) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-primary mx-1">Finish</button>
                                            </form>
                                        @elseif ($reservation->status === 'received')
                                            @if(!$isReservationInProgress && $isReservationFirstInList)
                                                <form method="POST" action="{{ route('reservation.start', $reservation->id) }}">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success mx-1">Begin</button>
                                                </form>
                                                @php($isReservationFirstInList = False)
                                            @endif
                                            <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#confirmCancellationModal-{{ $reservation->id }}">
                                                Cancel
                                            </button>
                                            @include('reservation.include._cancel_reservation_modal', ['id' => $reservation->id, 'action' => route('reservation.cancel_by_id', $reservation->id)])
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <span>There are no reservations to show.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
