<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController
{
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required | max:100',
        //     'session' => 'required | max:100',
        //     'semester' => 'required',
        //     'phone' => 'required | max:15',
        // ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required | max:100',
            'session' => 'required | max:100',
            'semester' => 'required',
            'phone' => 'required | max:15',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->messages(),
                'RESPONSE_CODE' => '422',
            ], 422);
        } else {
            $student = new Student;


            if (Student::where('phone', $request->phone)->exists()) {
                return response()->json([
                    'message' => 'Student already exists',
                    'RESPONSE_CODE' => '409',
                ], 409);
            } else {
                $student = Student::create($request->all());

                return response()->json([
                    'message' => 'Student created successfully',
                    'student' => $student,
                    'RESPONSE_CODE' => '201',
                ], 201);
            }
        }
    }

    public function index()
    {
        // fetch all data from students table using eloquent

        $students = Student::all();
        return response()->json([
            'message' => 'All students',
            'students' => $students,
            'RESPONSE_CODE' => '200',
        ], 200);
    }
    public function selectOne($phone)
    {
        // fetch single record from students table where phone == $phone
        $student = Student::where('phone', $phone)->first();
        if ($student) {
            return response()->json([
                'message' => 'Student found',
                'student' => $student,
                'RESPONSE_CODE' => '200',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Student not found',
                'RESPONSE_CODE' => '404',
            ], 404);
        }
    }

    public function update(Request $request, $phone)
    {
        // dd("ok");
        // dd($phone);
        $validator = Validator::make($request->all(), [
            'name' => 'required | max:100',
            'session' => 'required | max:100',
            'semester' => 'required',
            'phone' => 'required | max:15',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->messages(),
                'RESPONSE_CODE' => '422',
            ], 422);
        } else {
            $student = Student::where('phone', $phone)->first();
            // dd($student);
            if ($student) {

                $student->name = $request->name;
                $student->session = $request->session;
                $student->semester = $request->semester;
                $student->phone = $request->phone;
                $student->update();
                return response()->json([
                    'message' => 'Student record updated successfully',
                    'RESPONSE_CODE' => '200',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Student not found',
                    'RESPONSE_CODE' => '404',
                ], 404);
                dd($request->all());

                // dd("not found");
            }
        }
    }
    public function delete($phone){
        // delete record if exists where phone == $phone
        $student = Student::where('phone', $phone)->first();
        if ($student) {
            $student->delete();
            return response()->json([
                'message' => 'Student record deleted successfully',
                'RESPONSE_CODE' => '200',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Student not found',
                'RESPONSE_CODE' => '404',
            ], 404);
        }
    }
}
