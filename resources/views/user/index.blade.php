@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

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
                                <th scope="row">{{ $reservation->code }}</th>
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
                                            <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#confirmCancellationModal-{{ $reservation->code }}">
                                                Cancel
                                            </button>
                                            @include('reservation.include._cancel_reservation_modal', ['id' => $reservation->code, 'action' => route('reservation.cancel_by_id', $reservation->id)])
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
