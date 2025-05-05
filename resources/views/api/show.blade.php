@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h1>{{ $music->title }}</h1>
        </div>
        <div class="col text-end">
            <a href="{{ route('music.edit', $music) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('music.destroy', $music) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
            </form>
            <a href="{{ route('music.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @if($music->image)
                <img src="{{ $music->image }}" class="img-fluid rounded" alt="{{ $music->title }}">
            @else
                <div class="bg-light text-center p-5 rounded">No Image</div>
            @endif
        </div>
        <div class="col-md-8">
            <h2>{{ $music->title }}</h2>
            <p class="lead">By {{ $music->artist }}</p>
            <p><strong>Genre:</strong> {{ $music->genre }}</p>
            <h4>Description:</h4>
            <p>{{ $music->description }}</p>
        </div>
    </div>

    <div class="mt-4">
        <h3>API Information</h3>
        <p>You can access this music entry via the API:</p>
        <code>GET /api/music/{{ $music->id }}</code>
        <p class="mt-3">Or retrieve all entries:</p>
        <code>GET /api/music?limit=10</code>
        <p class="mt-3">Filter by genre:</p>
        <code>GET /api/music?genre={{ urlencode($music->genre) }}</code>
    </div>
@endsection
