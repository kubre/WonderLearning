<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
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
        return new StudentResource($student);
    }
}
