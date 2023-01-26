@php use GrahamCampbell\Markdown\Facades\Markdown; @endphp
@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-baseline">
        <h1 class="mb-4">My Walls</h1>
        <a href="{{ route('wall.create') }}" class="btn btn-primary">Create</a>
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
                            <span class="badge text-bg-warning">Draft</span>
                        @endif
                        @if ($wall->tags != null)
                            @foreach (json_decode($wall->tags, true) as $obj)
                                <span class="badge text-bg-secondary">
                                    {{ $obj['value'] }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                    @php $decomp = bzdecompress($wall->body); @endphp
                    <p class="card-text">
                        @markdown($decomp)
                    </p>
                </a>
            </div>
        </div>
    @endforeach
    <div class="d-flex justify-content-center">
        {{ $walls->links() }}
    </div>
@endsection
