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
            ->map(
                function ($status, $month) {
                    $presentCount = $status[1] ?? 0;
                    $absentCount = $status[0] ?? 0;
                    $percentage = ($presentCount === 0 && $absentCount === 0)
                    ? 0 : \round($presentCount / ($absentCount + $presentCount) * 100, 2);
                    return [
                        'month' => $month,
                        'percentage' => $percentage,
                    ];
                }
            )->values();
        return [
            'data' => [
                'attendance' => AttendanceResource::collection($attendance),
                'percentage' => $percentage,
            ],
        ];
    }
}
