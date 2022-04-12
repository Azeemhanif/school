@extends('student.layouts.main')
@section('content')

    <div class="container px-4 py-5 mx-auto">
        <div class="card card0">
            <div class="d-flex flex-lg-row flex-column-reverse">
                <div class="card card1">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-10 col-10 my-5">
                            <h1 class="mb-5 text-center heading"><span class="log">{{ __('Reset Password') }}</span></h1>

                            @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                        <input type="hidden" name="token" value="{{ $token }}">


                                <div class="form-group">
                                    <label for="email" class="col-md-4 col-form-label text-md-end" style="margin-left: -11px;">{{ __('Email Address') }}</label>

                                    <input type="text" id="email" name="email"

                                        class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus >
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="password" class="col-md-4 col-form-label text-md-end" style="margin-left: -11px;">{{ __('Password') }}</label>

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-12 col-form-label text-md-end" style="margin-left: -11px;">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                </div>



                                <div class="row justify-content-center px-3"> <button type="submit" class="btn-block btn-color">
                                    {{ __('Reset Password') }} </button> </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card card2">
                    <div class="my-auto mx-md-5 px-md-5 right text-center">
                        <h1 class="welcome"> WELCOME TO SCHOOL MANAGEMENT</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
