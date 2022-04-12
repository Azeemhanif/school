<?php

namespace App\Http\Controllers;


use App\Http\Traits\StudentTrait;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    use StudentTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.dashboard');
    }


    public function view()
    {
        $i = 1;
        $students = Student::orderBy('id', 'DESC')->get();
        return view('student.view', compact('students', 'i'));
    }


    public function create()
    {
        return view('student.add');
    }


    public function login()
    {
        return view('auth.login');
    }



    public function store(Request $request)
    {
        $this->validation($request);
        $this->save($request);

        if (isset($request->id)) {
            return redirect('admin/student/view')->with('success', 'Record updated successfully');
        } else {
            return redirect('admin/student/view')->with('success', 'Student created successfully');
        }
    }


    public function student_status(Request $request)
    {
        if (isset($request->id)) {
            for ($i = 0; $i < count($request->id); $i++) {
                $student = Student::find($request->id[$i]);
                if ($request->status == 'delete') {
                    $student->delete();
                } else {
                    $student->status = $request->status;
                    $student->save();
                }
            }
            return back()->with('success', "Records $request->status successfully");
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(Student $cr)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::where('id', $id)->first();
        if ($student != null) {
            return view('student.add', compact('student'));
        } else {
            return back();
        }
    }


    public function update(Request $request, Student $cr)
    {
    }

    public function activate($id)
    {

        $student = Student::findorfail($id);
        $student->status = 'activate';
        $student->update();
        return back()->with('success', 'Record activate successfully');
    }
    public function deactivate($id)
    {
        $student = Student::findorfail($id);
        $student->status = 'deactivate';
        $student->update();
        return back()->with('success', 'Record deactivate successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return back()->with('success', 'Record deleted successfully');
    }
}
