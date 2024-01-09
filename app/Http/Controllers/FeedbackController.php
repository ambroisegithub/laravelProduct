<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function postFeedback(Request $request)
    {
        $fields = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            // 'pregnancy_id' => 'required|exists:pregnancies,id',
            'message' => 'required|string',
            'date_time' => 'required|date',
            'status' => 'required|string',
        ]);

        $feedback = Feedback::create($fields);

        $response = [
            'feedback' => $feedback,
        ];

        return response($response, 201);
    }

    public function getAllFeedback()
    {
        $feedback = Feedback::all();

        $response = [
            'feedback' => $feedback,
        ];

        return response($response, 200);
    }

    public function getOneFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);

        $response = [
            'feedback' => $feedback,
        ];

        return response($response, 200);
    }

    public function updateFeedback(Request $request, $id)
    {
        $fields = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            // 'pregnancy_id' => 'required|exists:pregnancies,id',
            'message' => 'required|string',
            'date_time' => 'required|date',
            'status' => 'required|string',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update($fields);

        $response = [
            'feedback' => $feedback,
        ];

        return response($response, 200);
    }

    public function deleteFeedback($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        $response = [
            'message' => 'Feedback deleted successfully',
        ];

        return response($response, 200);
    }
}
