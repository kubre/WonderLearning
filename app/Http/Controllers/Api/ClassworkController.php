<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassworkResource;
use App\Models\Admission;
use App\Models\SchoolSyllabus;
use Illuminate\Http\Request;

class ClassworkController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Admission $admission)
    {
        return ClassworkResource::collection(
            SchoolSyllabus::with('syllabus')
                ->whereSchoolId($admission->school_id)
                ->whereHas('syllabus', function ($query) use ($admission) {
                    $query->where('program', $admission->program);
                })
                ->doesntHave('approval')
                ->get()
        );
    }
}
