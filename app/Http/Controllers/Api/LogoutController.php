<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Student $student, string $contact)
    {
        if ($student->father_contact == $contact) {
            $student->father_logged_at = null;
        } else {
            $student->mother_logged_at = null;
        }

        $student->save();

        return [
            'data' => [
                'contact' => $contact,
                'prn' => $student->prn,
            ]
        ];
    }
}
