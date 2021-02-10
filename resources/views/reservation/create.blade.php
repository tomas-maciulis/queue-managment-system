@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a reservation</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('reservation.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="specialist" class="col-md-4 col-form-label text-md-right">Specialist</label>

                                <div class="col-md-6">
                                    <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                        <option disabled selected value>Select a specialist from the list</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->room.', '.$user->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" name="submit">
                                        Create a reservation
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
