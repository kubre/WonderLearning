<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomeworkResource;
use App\Models\Division;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Division $division)
    {
        return HomeworkResource::collection($division->homeworks()->with('attachment')->get());
    }
}
