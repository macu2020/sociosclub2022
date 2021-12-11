<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailContact extends Mailable
{
    use Queueable, SerializesModels;

    public $useremail;

    public function __construct($useremail){   
        $this->useremail  =$useremail;
    }

     
    public function build(){
       
        $subject='Te damos la bienvenida al Club  ';
        return $this->view('Backend.Email.emailsocio')
                    ->subject($subject)
                   ->with([  'useremail'=>$this->useremail]);
    }
}
