<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetSandiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "(no reply) Reset Sandi Balai Wilayah Sungai Kalimantan II";

    public $user;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($opts)
    {
        $this->user = $opts['user'] ?? null;
        $this->link = $opts['link'] ?? null;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.reset-sandi');
    }
}
