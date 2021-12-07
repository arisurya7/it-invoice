<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $url;

    public function __construct($name, $url)
    {
        //
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user['name'] = $this->name;
        // $user['token'] = $this->token; 
        $user['url'] = $this->url; 

        return $this->from(config('mail.from.address'), config('mail.from.name'))
        ->subject('Password Reset Link')
        ->view('email.forgotpassword', ['user' => $user]);
    }
}
