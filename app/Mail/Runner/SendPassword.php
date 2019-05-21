<?php

namespace App\Mail\Runner;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        // $template = EmailTemplate::find(11);
        // $find = ['@first_name@', '@otp@', '@email@'];
        // $values = [$this->user->first_name, $this->otp, $this->user->email];
        // $this->body = str_replace($find, $values, $template->description);
        return $this->view('emails.runner.content');
    }
}
