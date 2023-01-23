@php use GrahamCampbell\Markdown\Facades\Markdown; @endphp
@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-baseline">
        <h1 class="mb-4">{{ __('My Walls') }}</h1>
        <a href="{{ route('wall.create') }}" class="btn btn-primary">{{ __('Create') }}</a>
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
                    <div class="card-subtitle mb-2">
                        @if ($wall->publish_status == 'draft')
                            <span class="badge text-bg-warning">{{ __('Draft') }}</span>
                        @endif
                        @if ($wall->tags != null)
                            @foreach (json_decode($wall->tags, true) as $obj)
                                <span class="badge text-bg-secondary">
                                    {{ $obj['value'] }}
                                </span>
                            @endforeach
                        @endif
                    </div>
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
