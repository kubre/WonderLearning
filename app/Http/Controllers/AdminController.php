<?php

namespace App\Http\Controllers;

use App\Models\Syllabus;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function get(Request $request)
    {
        return response()->json(Syllabus::get()->toTree()->toArray());
    }
}
