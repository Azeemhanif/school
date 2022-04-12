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

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                                <div class="form-group"> <input type="text" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Email*"
                                        class="form-control @error('email') is-invalid @enderror" required  autocomplete="email"
                                        autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="row justify-content-center px-3"> <button type="submit" class="btn-block btn-color">
                                    {{ __('Send Password Reset Link') }} </button> </div>
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
