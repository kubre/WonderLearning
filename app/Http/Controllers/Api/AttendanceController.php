<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceCollection;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(int $admissionId)
    {
        return AttendanceResource::collection(
            Attendance::with('divisionAttendance')
                ->whereAdmissionId($admissionId)
                ->get()
        );
    }
}
