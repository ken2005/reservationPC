<?php

namespace App\Http\Controllers;

use App\Mail\refus;
use App\Mail\validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    
    public function sendValidationEmail($email, $reservation,$ligneReservations)
    {
        Mail::to($email)->send(new validation($reservation,$ligneReservations));
    }
    
    public function sendRefusEmail($email, $reason, $reservation)
    {
        Mail::to($email)->send(new refus($reason, $reservation));
    }
    
}
