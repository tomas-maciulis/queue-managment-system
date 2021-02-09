@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    <span>Logged in as a display user.</span><br>
                    <div class="text-center">
                        <a class="btn btn-lg btn-primary" href="{{ route('display.show') }}">Show display screen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
