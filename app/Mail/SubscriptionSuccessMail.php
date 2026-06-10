<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionSuccessMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public $name;
    // Initialize the name property with the provided value when creating a new instance of the SubscriptionSuccessMail class.
    public function __construct($name)
    {
        $this->name = $name;
    }
    // Define the build method for the email, setting the subject to "Subscription Successfully".
    public function build()
    {
        return $this->subject('Subscription Successfully')->view('emails.subscription-success');
    }
}
