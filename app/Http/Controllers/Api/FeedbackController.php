<?php

namespace App\Http\Controllers\Api;

use Session;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FeedbackRequest;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Feedback::with('user', 'comments', 'comments.user')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeedbackRequest $request)
    {
        $feedback = new Feedback();
        $feedback->user_id = Auth::id();
        $feedback->title = $request->title;
        $feedback->description = $request->description;
        $feedback->category = $request->category;
        $feedback->save();

        if ($feedback->id) {
            $status = true;
            $message = 'Feedback is created successfully';
        } else {
            $status = false;
            $message = 'Something went wrong while creating feedback';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        return $feedback;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FeedbackRequest $request, Feedback $feedback)
    {
        if ($feedback) {
            $feedback->title = $request->title;
            $feedback->description = $request->description;
            $feedback->category = $request->category;
            $feedback->save();

            $status = true;
            $message = 'Feedback is updated successfully';
        } else {
            $status = false;
            $message = 'Feedback not found';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        if ($feedback) {
            $feedback->delete();

            $status = true;
            $message = 'Feedback is deleted successfully';
        } else {
            $status = false;
            $message = 'Feedback not found';
        }
 
        return $data = [
            'status' => $status,
            'message' => $message
        ];
    }
}
