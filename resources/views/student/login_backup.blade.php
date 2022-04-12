@extends('student.layouts.main')
@section('content')
    @include('student.layouts.header')

    <div class="container px-4 py-5 mx-auto">
        <div class="card card0">
            <div class="d-flex flex-lg-row flex-column-reverse">
                <div class="card card1">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-10 col-10 my-5">
                            <h1 class="mb-5 text-center heading"><span class="log">LOG</span><span
                                    class="login">IN</span></h1>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group"> <input type="text" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Email*"
                                        class="form-control @error('email') is-invalid @enderror" autocomplete="email"
                                        autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group"> <input type="password" id="psw" name="password"
                                        placeholder="Password*" class="form-control @error('password') is-invalid @enderror"
                                        autocomplete="current-password">
                                    <span toggle="#psw" class="fa fa-fw  fa-eye field-icon toggle-password log"></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row justify-content-end px-3 forget">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}"> {{ __('Forgot Password?') }}</a>
                                    @endif
                                </div>

                                <div class="row justify-content-center px-3"> <button class="btn-block btn-color">
                                        {{ __('SIGN IN') }} </button> </div>
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
