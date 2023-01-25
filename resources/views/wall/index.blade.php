@php use GrahamCampbell\Markdown\Facades\Markdown; @endphp
@extends('layouts.app')

@section('content')
    <h1 class="mb-4">{{ __('Walls') }}</h1>

    @if ($walls->count() == 0)
        <p>{{ __('No walls found. Come back later...') }}</p>
        <p>
            {{ __('Or,') }} <a href="{{ route('wall.create') }}">{{ __('create one') }}</a> {{ __('now.') }}
        </p>
    @else
        @php
            $count = $walls->count();

            // round up to the nearest 3
            $rowCnt = (ceil($count / 4) * 4) / 4;

            $i = 0;
        @endphp

        @foreach ($walls as $wall)
            @if ($i % 4 == 0)
                <div class="row mb-3">
            @endif
            <div class="col-3">
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
            @if ($i % 4 == 3 || $i == $count - 1)
                </div>
            @endif
            @php $i++; @endphp
        @endforeach

        <div class="d-flex justify-content-center">
            {{ $walls->links() }}
        </div>
    @endif
@endsection

@section('dload')
    <script src="{{ asset('js/hljs.js') }}"></script>
@endsection
