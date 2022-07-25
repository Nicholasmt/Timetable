<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AddUser_mails extends Mailable
{
    use Queueable, SerializesModels;
     public $users;
     public $randomPass;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( User $users, $randomPass)
    {
         $this->users = $users;
         $this->randomPass = $randomPass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.AddUser-mail');
    }
}
