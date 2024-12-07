<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function store(Request $request) 
    {
            //Validate the request
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:students,email',
                'phone' => 'required',
                'address' => 'required',
            ]);
            
            //use the validated data to create a student
            $student = Student::create($validated);

            //redirect back with success message 
            return redirect()-> route('dashboard')->with([
                'success' => 'Student Added Successfully', 
                'newStudent' => $student,
            ]);
    }

    public function destroy (Student $student)
    {
        $student->delete();
        return redirect()->route('dashboard')->with('deleted',
        'Student Deleted Successfully');
    }
      

    public function edit(Student $student)
    {
        return view('edit-student', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email,'. $student->id,
            'phone' => 'required',
            'address' => 'required',
        ]);

        $student->update($validated);

        return redirect()->route('dashboard')->with('success', 'Student updated Successfully');
    }
}
