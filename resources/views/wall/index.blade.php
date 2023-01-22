@extends('layouts.app')

@section('content')
    <!-- pagination $walls[20] -->
    <!-- display as cards with an excerpt of the body -->
    <!-- each card should have a link to the show page -->

    <h1 class="mb-4">Walls</h1>

    @if ($walls->count() == 0)
        <p>{{ __('No walls found. Come back later...') }}</p>
        <p>
            {{ __('Or,') }} <a href="{{ route('wall.create') }}">{{ __('create one') }}</a> {{ __('now.') }}
        </p>
    @else

        @php
            $count = $walls->count();

            // round up to the nearest 3
            $rowCnt = ceil($count / 4) * 4 / 4;

            $i = 0;
        @endphp

        @foreach ($walls as $wall)
            @if ($i % 4 == 0)
                <div class="row mb-3">
                    @endif
                    <!-- 4 columns -->
                    <div class="col-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="{{ route('wall.show', $wall->id) }}">
                                        {{ $wall->title }}
                                    </a>
                                </h4>
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
                                <p class="card-text">
                                    {{ Str::limit(bzdecompress($wall->body), 1000) }}
                                </p>
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
