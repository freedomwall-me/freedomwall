@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Verify Your Email Address</h3>
                </div>

                <div class="card-body">
                    Before proceeding, please check your email for a verification link.
                    If you did not receive the email,
                    <a href="{{ route('verification.resend') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('vf-form').submit();">
                        click here to request another
                    </a>.
                    <form id="vf-form" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
