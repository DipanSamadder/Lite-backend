<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ManageMail;
use Mail;

class MailController extends Controller
{
    public function testmail()
    {
        $content['title'] = 'test Mail template';
        $content['body'] = 'test Mail template body';
        $array['view'] = 'emails.test';
        $array['subject'] = 'Your order has been placed';
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = $content;

        Mail::to('dipan.cityinnovates@gmail.com')->send(new ManageMail($array));
    }

    public function cf_submite_mail($to, $from, $subject = "Here is Subject", $content, $view)
    {
        $array['view'] = $view;
        $array['subject'] = $subject;
        $array['from'] = $from !='' ? $from : env('MAIL_USERNAME');
        $array['content'] = $content;
        Mail::to($to)->send(new ManageMail($array));
    }
}
