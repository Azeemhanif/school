<?php

namespace App\Http\Traits;

use App\Models\Student;
use App\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;

trait StudentTrait
{

    public function validation($request)
    {
        // dd($request);

        return  $request->validate(
            [
                'id' => 'exists:students,id',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|string|email|max:255',
                'phone' => 'required',
                'password' => [(!isset($request->id)) ? 'required' : null,],
                'age' => 'required',
                'gender' => 'required',
                'start_date' => 'required|date',
                'dob' => 'required|date|before:start_date',
                'address' => 'required',
            ],
            [
                'phone.required' => 'The phone number field is required.',
                'dob.required' => 'The date of birth field is required.',
                'dob.before' => 'The date of birth must be a date before to today date.',
            ]
        );
    }

    public function save($request)
    {

        if (isset($request->id)) {
            $student =  Student::find($request->id);
        } else {
            $student = new Student();
        }
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        if (isset($request->password) && $request->password != null) {
            $student->password = Hash::make($request->password);
        }
        $student->age = $request->age;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
        $student->address = $request->address;
        $student->address2 = $request->address2;
        $student->save();
        return $student;
    }
}
