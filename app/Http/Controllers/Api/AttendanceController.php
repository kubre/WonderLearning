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
        $attendance = Attendance::with('divisionAttendance')
            ->whereAdmissionId($admissionId)
            ->get();
        $percentage = $attendance->groupBy('divisionAttendance.month')
            ->map(fn ($item) => $item->countBy('is_present'))
            ->map(fn ($status, $month) => [
                'month' => $month,
                'percentage' => \round($status[1] / ($status[0] + $status[1]) * 100, 2),
            ])
            ->values();
        return [
            'data' => [
                'attendance' => AttendanceResource::collection($attendance),
                'percentage' => $percentage,
            ],
        ];
    }
}
