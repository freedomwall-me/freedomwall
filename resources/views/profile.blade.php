@php use GrahamCampbell\Markdown\Facades\Markdown; @endphp
@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-baseline">
        <h1 class="mb-4">{{ __('My Walls') }}</h1>
        <a href="{{ route('wall.create') }}" class="btn btn-success">{{ __('Create') }}</a>
    </div>
    @foreach ($walls as $wall)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('wall.show', $wall->id) }}" class="no-decor">
                        <h4 class="card-title">{{ $wall->title }}</h4>
                    </a>
                    @include('templates.actions')
                </div>
                <a href="{{ route('wall.show', $wall->id) }}" class="no-decor">
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
                        {!! Markdown::convert(Str::limit(bzdecompress($wall->body), 1000))->getContent() !!}
                    </p>
                </a>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-center">
        {{ $walls->links() }}
    </div>
@endsection
