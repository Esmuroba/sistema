<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class dispersedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payrollRequest)
    {
        $this->payrollRequest = $payrollRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Dispersión de: ' . $this->payrollRequest->collaborator_detail->getFullName())
                    ->view('emails.dispersed', ['payrollRequest' => $this->payrollRequest]);
    }
}
