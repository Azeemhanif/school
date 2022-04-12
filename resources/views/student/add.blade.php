@extends('student.layouts.main')
@section('content')
    @include('student.layouts.header')

    <div class="container px-4 py-5 mx-auto">
        <div class="card card0 cardd">
            <div class="card-body">
                <br>
                <a href="{{ url()->previous() }}" class="previous1"> <i class="fas fa-angle-left lesthen"></i> Back</a>
                <br>
                <h2 class="card-title mt-4 addstudent">
                    @if (isset($student))
                        Edit Student
                    @else
                        Add Student
                    @endif
                </h2>
                <div class="row">
                    <div class="col-12">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <form action="{{ route('student.store') }}" method="post">
                            @csrf

                            @if (isset($student))
                                <input type="hidden" class=" @error('id') is-invalid @enderror" name="id"
                                    value="{{ $student->id }}">

                                @error('id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            @endif
                            <div class="row">
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        {{-- @dd($student) --}}
                                        <label for="exampleInputEmail1">First Name*</label>
                                        <input type="text"
                                            class="form-control addstudent @error('first_name') is-invalid @enderror"
                                            id="exampleInputEmail1" name="first_name" aria-describedby="emailHelp"
                                            @if (isset($student)) value="{{ $student->first_name }}" @else value="{{ old('first_name') }}" @endif
                                            placeholder="Enter first name">

                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name*</label>
                                        <input type="text"
                                            class="form-control addstudent  @error('last_name') is-invalid @enderror"
                                            id="exampleInputEmail1" name="last_name"
                                            @if (isset($student)) value="{{ $student->last_name }}"  @else value="{{ old('last_name') }}" @endif
                                            aria-describedby="emailHelp" placeholder="Enter last name">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email*</label>
                                        <input type="email"
                                            class="form-control addstudent @error('email') is-invalid @enderror"
                                            id="exampleInputEmail1" name="email"
                                            @if (isset($student)) value="{{ $student->email }}" @else value="{{ old('email') }}" @endif
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone Number*</label>
                                        <input type="text"
                                            class="form-control addstudent  @error('phone') is-invalid @enderror"
                                            id="exampleInputEmail1" name="phone"
                                            @if (isset($student)) value="{{ $student->phone }}" @else value="{{ old('phone') }}" @endif
                                            aria-describedby="emailHelp" placeholder="Enter number">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- @if (isset($student))
                                    <input type="hidden" value="{{ $student->password }}"
                                        class="form-control addstudent " id="exampleInputEmail1" name="password"
                                        aria-describedby="emailHelp" placeholder="Enter password">
                                @else --}}
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Password*</label>
                                        <input type="password"
                                            class="form-control addstudent  @error('password') is-invalid @enderror"
                                            id="exampleInputEmail1" value="{{ old('password') }}" name="password"
                                            aria-describedby="emailHelp" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- @endif --}}


                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Age*</label>
                                        <input type="number"
                                            class="form-control addstudent @error('age') is-invalid @enderror"
                                            id="exampleInputEmail1" name="age"
                                            @if (isset($student)) value="{{ $student->age }}"  @else value="{{ old('age') }}" @endif
                                            aria-describedby="emailHelp" placeholder="Enter age">
                                        @error('age')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Gender*</label>
                                        <select id="" name="gender"
                                            class="form-control addstudent @error('gender') is-invalid @enderror">

                                            <option value="">Select Gender</option>
                                            <option
                                                @if (isset($student) && $student->gender == 'male') selected  @else {{ old('gender') === 'male' ? 'selected' : '' }} @endif
                                                value="male">Male
                                            </option>
                                            <option
                                                @if (isset($student) && $student->gender == 'female') selected  @else {{ old('gender') === 'female' ? 'selected' : '' }} @endif
                                                value="female">Female
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="start_date" value="{{ date('Y-m-d') }}" id="">

                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Date of Birth*</label>
                                        <input type="date"
                                            class="form-control addstudent @error('dob') is-invalid @enderror"
                                            id="exampleInputEmail1"
                                            @if (isset($student)) value="{{ $student->dob }}"  @else value="{{ old('dob') }}" @endif
                                            name="dob" aria-describedby="emailHelp" placeholder="Enter dob">
                                        @error('dob')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address*</label>
                                        <input type="text"
                                            class="form-control addstudent @error('address') is-invalid @enderror"
                                            id="exampleInputEmail1"
                                            @if (isset($student)) value="{{ $student->address }}"  @else value="{{ old('address') }}" @endif
                                            name="address" aria-describedby="emailHelp" placeholder="Enter address">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address 2</label>
                                        <input type="text" class="form-control addstudent" id="exampleInputEmail1"
                                            name="address2"
                                            @if (isset($student)) value="{{ $student->address2 }}"  @else value="{{ old('address2') }}" @endif
                                            aria-describedby="emailHelp" placeholder="Enter address">
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary  mt-2 btnsubmit">
                                Submit
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
