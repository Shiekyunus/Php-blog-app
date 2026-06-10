<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionSuccessMail;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    // Ensure that only authenticated users can access the methods in this controller.
    public function __construct()
    {
        $this->middleware('auth');
    }
    // store a new subscription for the authenticated user and send a confirmation email.
    public function store()
    {
        Subscription::updateOrCreate(
            ['user_id' => Auth::id()],
            ['status' => 'active'],
        );
        Mail::to(Auth::user()->email)->queue(new SubscriptionSuccessMail(Auth::user()->name));
        return back()->with('success', 'Subscribed successfully');
    }
    // Unsubscribe the authenticated user from the subscription service.
    public function destroy()
    {
        Subscription::where('user_id', Auth::id())->update([
           'status' => 'unsubscribed',
        ]);
        return back()->with('success', 'unsubscribed successfully');
    }
}
