<?php

namespace App\Http\Controllers;

use App\Models\Syllabus;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function get(Request $request)
    {
        return response()->json(
            Syllabus::withoutGlobalScopes()
                ->whereBetween('created_at', [$request->query('from_date'), $request->query('to_date')])
                ->get()
                ->toTree()
                ->toArray()
        );
    }
}
