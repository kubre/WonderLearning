<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function get(Request $request)
    {
        return MessageResource::collection(Message::query()
            ->where('user_id', $request->teacher)
            ->where('student_id', $request->student)
            ->orderBy('sent_at', 'desc')
            ->limit(20)
            ->get()
            ->sortBy('sent_at'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'body' => 'required|max:500',
            'teacher' => 'required|integer|min:1',
            'student' => 'required|integer|min:1',
            'is_teacher' => 'required|boolean',
        ]);

        Message::create([
            'body' => $data['body'],
            'user_id' => $data['teacher'],
            'student_id' => $data['student'],
            'is_teacher' => $data['is_teacher'],
        ]);
        return ['message' => 'success'];
    }
}
