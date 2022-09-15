@extends('layouts.app2')
@section('content')
    <div class="container mt-5">
        <div class="card border-success mb-3">
            <div class="card-header bg-transparent border-success">Checkin</div>
            <div class="card-body text-center">
                <form action="{{ route('participant.checkin.status') }}" method="POST">
                    @csrf
                    <div class="input-group input-group-lg">
                        <div class="input-group-prepend">
                            <span class="input-group-text">No Tiket</span>
                        </div>
                        <input type="text" class="form-control" name="uuid" aria-label="No Tiket" required>
                    </div>

                    <button type="submit" class="btn btn-success mt-5">Checkin</button>
                </form>
            </div>
        </div>
    </div>
@endsection
