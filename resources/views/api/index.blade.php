@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h1>My Favorite Music</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('music.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>

    <div class="row">
        @foreach($music as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($item->image)
                        <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->title }}">
                    @else
                        <div class="bg-light text-center p-5">No Image</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $item->artist }}</h6>
                        <p class="card-text"><small class="text-muted">Genre: {{ $item->genre }}</small></p>
                        <p class="card-text">{{ Str::limit($item->description, 100) }}</p>
                        <a href="{{ route('music.show', $item) }}" class="btn btn-info">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach

        @if($music->isEmpty())
            <div class="col-12">
                <div class="alert alert-info">
                    No music entries found. <a href="{{ route('music.create') }}">Add one!</a>
                </div>
            </div>
        @endif
    </div>
@endsection
