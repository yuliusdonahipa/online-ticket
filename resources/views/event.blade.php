@extends('layouts.app2')
@section('content')
    <div class="container">
        <div class="card-deck mb-3">
            <div class="card">
                <div class="card-body">
                    <img class="card-img-top" src="{{ $event->image }}">
                    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                        <h1 class="display-4">{{ $event->name }}</h1>
                        <p class="lead">{{ $event->desc }}</p>
                        <h5 class="mb-3">{{ 'Rp. ' . number_format($event->price, 0, ',', '.') }}</h5>
                        <a href="{{ route('event.create', $event->slug) }}" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
