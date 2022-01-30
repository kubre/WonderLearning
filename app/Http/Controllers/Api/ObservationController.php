<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObservationResource;
use App\Models\Admission;
use App\Models\PerformanceReport;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    public function __invoke($admission_id)
    {
        return ObservationResource::collection(
            PerformanceReport::whereAdmissionId($admission_id)
                ->get()
        );
    }
}
