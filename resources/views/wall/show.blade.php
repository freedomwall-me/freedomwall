@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="justify-content-between">
            <h1>{{ $wall->title }}</h1>
        </div>
        <small class="text-muted">Published on {{ $wall->created_at }}</small>
        @if ($wall->publish_status == 'draft')
            <strong>
                <small class="text-muted">This work is only visible to you. Publish it for other people to see this
                    work.</small>
            </strong>
        @endif
        <div>
            @if ($wall->publish_status == 'draft')
                <span class="badge text-bg-warning">Draft</span>
            @endif
            @foreach (json_decode($wall->tags, true) as $obj)
                <span class="badge text-bg-secondary">
                    {{ $obj['value'] }}
                </span>
            @endforeach
        </div>
        <div class="mt-3">
            @markdown
            {{ bzdecompress($wall->body)  }}
            @endmarkdown
        </div>
    </div>
@endsection
