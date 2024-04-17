<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestDecline extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($collaborator, $payrollRequest)
    {
        $this->collaborator = $collaborator;
        $this->payrollRequest = $payrollRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Resolución de Solicitud de Adelanta Nómina')
            ->view('emails.requests.requestDecline', 
                [
                    'collaborator' => $this->collaborator, 
                    'payrollRequest' => $this->payrollRequest
                ]);
    }
}
