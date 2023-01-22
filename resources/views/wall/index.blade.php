@extends('layouts.app')

@section('content')
    <!-- pagination $walls[20] -->
    <!-- display as cards with an excerpt of the body -->
    <!-- each card should have a link to the show page -->

    <h1 class="mb-4">Walls</h1>

    @if ($walls->count() == 0)
        <p>No walls found. Come back later...</p>
        <p>
            Or, <a href="{{ route('wall.create') }}">create one</a> now.
        </p>
    @endif

    @foreach ($walls as $wall)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('wall.show', $wall->id) }}">
                        {{ $wall->title }}
                    </a>
                </h4>
                <!-- tags -->
                <div class="card-subtitle mb-2">
                    @foreach (json_decode($wall->tags, true) as $obj)
                        <span class="badge text-bg-secondary">
                            {{ $obj['value'] }}
                        </span>
                    @endforeach
                </div>
                <p class="card-text">Placeholder</p>
            </div>
        </div>
    @endforeach
@endsection
