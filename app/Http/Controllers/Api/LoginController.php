<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Throwable;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $code = \explode('/', $request->prn)[1];
            $student = Student::whereCode($code)
                ->where(function ($query) use ($request) {
                    $query->orWhere('father_contact', $request->contact);
                    $query->orWhere('mother_contact', $request->contact);
                })
                ->firstOrFail();
        } catch (Throwable $t) {
            return \api_error('Incorrect login info!');
        }
        $request->merge([
            'school_id' => $student->school_id,
        ]);

        if ($student->father_contact == $request->contact) {
            if (!is_null($student->father_logged_at)) {
                return \api_error('Already logged in on another device!');
            }
            $student->father_logged_at = \now();
        } else {
            if (!is_null($student->mother_logged_at)) {
                return \api_error('Already logged in on another device!');
            }
            $student->mother_logged_at = \now();
        }

        $student->save();

        return new StudentResource($student);
    }
}
