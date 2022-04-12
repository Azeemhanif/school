@extends('student.layouts.main')
@section('content')
    @include('student.layouts.header')
    <?php
    $role = Auth::user()->role;
    ?>


    <div class="container px-4 py-5 mx-auto">
        <div class="card card0 cardd">
            <div class="card-body">
                <br>
                <div class="row ">
                    <div class="col-md-4 mb-4">
                        <button class="btn btn-primary statusBtn statusBtn1 ">
                            <a href="{{ url("/$role/student/add") }}" class="editlink1">
                                Add
                            </a></button>
                    </div>
                    <div class="col-md-8 text-right">
                        <button class="btn btn-dark statusBtn" id="activate">Active</button>
                        <button class="btn btn-secondary statusBtn" id="deactivate">Deactive</button>
                        <button class="btn btn-danger statusBtn" id="delete">Delete</button>
                    </div>
                </div>


                <h2 class="card-title mt-4 addstudent">Student List</h2>
                <div class="row">
                    <div class="col-12">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        <form method="post" action="{{ url("$role/student/status") }}">
                            @csrf
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered dt-responsive display nowrap"
                                    cellspacing="0" style="width:100%">

                                    <thead>
                                        <tr>
                                            <th> <input type="checkbox" id="allcheck" class="allCheck"> </th>
                                            <th>ID</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td><input type="checkbox" value="{{ $student->id }}"
                                                        class="status" name="id[]">
                                                </td>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $student->first_name }}</td>
                                                <td>{{ $student->last_name }}</td>
                                                <td>{{ $student->age }}</td>
                                                <td>{{ $student->gender }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->address }}</td>

                                                <td>
                                                    <div class="dropdown">
                                                        <button
                                                            @if ($student->status == 'activate') class="btn btn-primary dropdown-toggle" @elseif($student->status == 'deactivate') class="btn btn-danger dropdown-toggle" @endif
                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            {{ $student->status }}
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a href="{{ url("$role/student/activate/$student->id") }}"
                                                                class="dropdown-item @if ($student->status == 'activate') active @endif"
                                                                tabindex="0">Activate</a>
                                                            <a href="{{ url("$role/student/deactivate/$student->id") }}"
                                                                class="dropdown-item  @if ($student->status == 'deactivate') active @endif"
                                                                tabindex="0">Deactivate</a>
                                                            <a href="{{ url("$role/student/delete/$student->id") }}"
                                                                class="dropdown-item" tabindex="0">Delete</a>
                                                        </div>
                                                    </div>
                                                    {{-- <button   @if ($student->status == 'activate') class="btn btn-primary" @elseif($student->status== 'deactivate') class="btn btn-danger" @endif>{{$student->status}}</button> --}}
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm p-2">
                                                        <a href="{{ route('student.edit', $student->id) }}"
                                                            class="editlink">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm p-2">
                                                        <a href="{{ url("/$role/student/delete", $student->id) }}"
                                                            class="editlink  delete-confirm">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach

                                        <div class="values">
                                            <input type="hidden" name="status" id="stdStatus" value="activate">
                                        </div>
                                        <button type="submit" name="submit" class="d-none" id="submitBtn">
                                            submit
                                        </button>
                                </table>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
