@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
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
                        @foreach($reservations as $reservation)
                            <tr>
                                <th scope="row">{{ $reservation->code }}</th>
                                <td>{{ $reservation->start_at }}</td>
                                <td>{{ $reservation->status }}</td>
                                <td>
                                    <div class="row float-right">
                                        @if ($reservation->status === 'in progress')
                                            <form method="POST" action="{{ route('reservation.finish', $reservation->id) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-primary mx-1">Finish</button>
                                            </form>
                                        @elseif ($reservation->status === 'received')
                                            <form method="POST" action="{{ route('reservation.start', $reservation->id) }}">
                                                @csrf
                                                <button class="btn btn-sm btn-primary mx-1">Begin</button>
                                            </form>
                                            <button type="button" class="btn btn-danger btn-sm mx-1" data-toggle="modal" data-target="#confirmCancellationModal-{{ $reservation->code }}">
                                                Cancel
                                            </button>
                                            @include('reservation.include._cancel_reservation_modal', ['id' => $reservation->code, 'action' => route('reservation.cancelById', $reservation->id)])
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
