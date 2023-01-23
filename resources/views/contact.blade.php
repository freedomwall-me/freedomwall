@extends('layouts.app')

@section('content')
    <h1 class="mb-4">{{ __('Contact us') }}</h1>

    <p>
        {{ __('Provide feedback by filling out the form below.') }}
        <br>
        {{ __('You can also contact us directly:') }} <a href="mailto:support@freedomwall.me">support@freedomwall.me</a>
    </p>

    <form method="POST" action="{{ route('email.store') }}">
        @csrf
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="form-outline mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                   placeholder="name@example.com">
            @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="form-outline mb-4">
            <label class="form-label" for="body">{{ __('Content') }}</label>
            <textarea name="body" class="form-control @error('body') is-invalid @enderror"
                      style="min-height: 10em;"></textarea>
            @error('body')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <input type="submit" class="btn btn-primary" value="Send">
    </form>
@endsection
