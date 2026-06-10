<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FeedbackController extends Controller
{
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth')->except('store', 'create');
        $this->middleware('permission:review feedback')->only(['received Feedback','updateStatus']);
        $this->middleware('permission:delete feedback')->only('destroy');
    }
    // Show the form for creating a new feedback.
    public function create()
    {
        if (Auth::check()) {
            $users = User::role(['Admin','Editor','Author'])->latest()->get();
            return view('feedback.create', compact('users'));
        } else {
            return view('feedback.create');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    // store a newly created feedback in storage.
    public function store(Request $request)
    {
        //
        $request->validate([
           'type' => 'required',
           'subject' => 'required|string|max:255',
           'message' => 'required|string',
        ]);
        if (Auth::check()) {
            if ($request->type == 'contact_author') {
                Feedback::create([
                    'user_id' => Auth::id(),
                    'target_user_id' => $request->user_id,
                    'type' => $request->type,
                    'subject' => $request->subject,
                    'message' => $request->message,
                    'status' => 'open',
                ]);
                return back()->with('success', 'Message sent to author successfully');
            } else {
                Feedback::create([
                    'user_id' => Auth::id(),
                    'target_user_id' => null,
                    'type' => $request->type,
                    'subject' => $request->subject,
                    'message' => $request->message,
                    'status' => 'open',
                ]);
                return back()->with('success', 'Feedback submitted successfully');
            }
        } else {
            Feedback::create([
                 'user_id' => null,
                 'target_user_id' => null,
                 'type' => $request->type,
                 'subject' => $request->subject,
                 'message' => $request->message,
                 'status' => 'open',
            ]);

            return back()->with('success', 'Feedback submitted successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    // Display the feedbacks sent by the authenticated user.
    public function sentFeedbacks()
    {
        //
        $feedbacks = Feedback::where('user_id', Auth::id())->latest()->paginate(7);
        return view('feedback.sent', compact('feedbacks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Display the feedbacks received by the authenticated user.
    public function receivedFeedbacks()
    {
        if (Auth::user()->hasAnyRole(['Admin','Editor'])) {
            $feedbacks = Feedback::where('target_user_id', Auth::id())->orWhereIn('type', ['issue','improvement'])->latest()->paginate(7);
        } else {
            $feedbacks = Feedback::where('target_user_id', Auth::id())->latest()->paginate(7);
        }
        return view("feedback.reviewed", compact('feedbacks'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update the status of the feedback.
    public function updateStatus(Request $request, Feedback $feedback)
    {
        //
        $request->validate([
            'status' => 'required|in:open,reviewed,closed',
        ]);
        $feedback->update([
            'status' => $request->status,
        ]);
        return back()->with('success', 'Feedback status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Delete the feedback.
    public function destroy(Feedback $feedback)
    {
        //
        $feedback->delete();
        return back()->with('success','feedback deleted successfully');
    }
}
