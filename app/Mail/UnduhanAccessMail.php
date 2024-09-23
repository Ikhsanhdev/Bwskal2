<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UnduhanAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "(no reply) Hasil permohonan akses berkas";

    public $data;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($opts)
    {
        $this->data = $opts['data'] ?? null;
        $this->link = $opts['link'] ?? null;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.unduhan-access');
    }
}
