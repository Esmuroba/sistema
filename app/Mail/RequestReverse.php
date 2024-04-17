<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestReverse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($collaborator,$payrollRequest)
    {
        $this->payrollRequest = $payrollRequest;
        $this->collaborator = $collaborator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reversión de la Solicitud')
                    ->view('emails.requests.requestReverse',
                    [
                        'collaborator' => $this->collaborator, 
                        'payrollRequest' => $this->payrollRequest
                    ]);
    }
}
