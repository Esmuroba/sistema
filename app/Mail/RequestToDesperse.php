<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestToDesperse extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($collaborator, $payrollRequestDetails, $user)
    {
        $this->collaborator = $collaborator;
        $this->payrollRequestDetails = $payrollRequestDetails;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nueva Solicitud de Adelanto por Dispersar')
            ->view('emails.requests.requestToDisperse', 
                [
                    'collaborator' => $this->collaborator,
                    'payrollRequestDetails' => $this->payrollRequestDetails,
                    'user' => $this->user
                ]);
    }
}
