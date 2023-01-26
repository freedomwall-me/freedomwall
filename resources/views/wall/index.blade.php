@php use GrahamCampbell\Markdown\Facades\Markdown; @endphp
@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Walls</h1>

    @if ($walls->count() == 0)
        <p>No walls found. Come back later...</p>
        <p>
            Or, <a href="{{ route('wall.create') }}">create one</a> now.
        </p>
    @else
        <div class="row">
            @foreach ($walls as $wall)
                <div class="col-xs-12 col-md-6 col-xxl-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('wall.show', $wall->id) }}" class="no-decor">
                                    <h4 class="card-title">{{ $wall->title }}</h4>
                                </a>
                                @auth
                                    <!-- check if the user is the owner of the wall -->
                                    @if (Auth::id() == $wall->user_id)
                                        @include('templates.actions')
                                    @endif
                                @endauth
                            </div>
                            <!-- tags -->
                            @if ($wall->tags != null)
                                <div class="card-subtitle mb-2">
                                    @foreach (json_decode($wall->tags, true) as $obj)
                                        <span class="badge text-bg-secondary">
                                            {{ $obj['value'] }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            @php
                                $decomp = bzdecompress($wall->body);
                                $limit = Str::limit($decomp, 1000);
                            @endphp
                            <p class="card-text">
                                @markdown($limit)
                            </p>
                            <a href="{{ route('wall.show', $wall->id) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $walls->links() }}
        </div>
    @endif
@endsection

@section('dload')
    <script src="{{ asset('js/hljs.js') }}"></script>
@endsection
