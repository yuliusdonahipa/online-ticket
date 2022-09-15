@extends('layouts.app2')
@section('content')
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Event 2022</h1>
        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste dolorum, eligendi blanditiis animi
            non sapiente ab voluptatem hic temporibus eaque id laboriosam odit tempora, sint consequatur placeat praesentium
            minima numquam. Pariatur quos rerum nihil itaque, recusandae tempore id quaerat quo, aperiam perferendis non,
            optio possimus necessitatibus nostrum consequuntur quisquam iusto.</p>
    </div>

    <div class="container">
        <div class="card-deck">
            @foreach ($events as $event)
                <div class="card">
                    <img class="card-img-top" src="{{ $event->image }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <div class="card-text">
                            <p>{{ $event->desc }}</p>
                            <h5 class="mb-3">{{ "Rp. " . number_format($event->price, 0, ',', '.'); }}</h5>
                            <a href="{{ route('event.detail', $event->slug) }}">See Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
