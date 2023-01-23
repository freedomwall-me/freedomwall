@php use GrahamCampbell\Markdown\Facades\Markdown; @endphp
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="d-flex justify-content-between">
            <h1>{{ $wall->title }}</h1>
            <!-- check if the user is the owner of the wall -->
            @if (Auth::user()->id == $wall->user_id)
                @include('templates.actions')
            @endif
        </div>
        <small class="text-muted">{{ __('Published on ') . $wall->created_at }}</small>
        @if ($wall->publish_status == 'draft')
            <strong>
                <small class="text-muted">{{ __('This work is only visible to you. Publish it for other people to see this
                    work.') }}</small>
            </strong>
        @endif
        <div>
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
        <div class="mt-3">
            {!! Markdown::convert(bzdecompress($wall->body))->getContent() !!}
        </div>
    </div>
@endsection
