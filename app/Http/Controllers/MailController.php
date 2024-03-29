<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\YatraMail;

class MailController extends Controller
{
    public function index($email,$name)
    {
        $mailData = [

            'title'=>'Yatra Welcomes!',
            'name' => $name,
            'body'=> 'Thank You For Registering In Yatra'
        ];

        Mail::to($email)->send(new YatraMail($mailData));

    }
}
