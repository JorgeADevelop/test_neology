<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $balance_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($balance_data)
    {
        $this->balance_data = $balance_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.binnacle');
    }
}
