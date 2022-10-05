<?php

namespace App\Http\Controllers;

use App\Mail\ChangeEmail;
use App\Mail\Contact;
use App\Mail\ForgotPasswordMail;
use App\Mail\orderCancelled;
use App\Mail\orderCompleteBuyer;
use App\Mail\orderCompleteSeller;
use App\Mail\orderDelivered;
use App\Mail\SignupEmail;
use App\Mail\OrderMail;

use App\Mail\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendSignupEMail($name, $email, $verification_code, $route){
        $data = [
          'name' => $name,
          'verification_code' => $verification_code,
            'route' =>$route
        ];
        Mail::to($email)->send(new SignupEmail($data));
    }

    public static function sendEMailChangeLink($email, $verification_code, $route){
        $data = [
            'email' => $email,
            'verification_code' => $verification_code,
            'route' =>$route
        ];
        Mail::to($email)->send(new ChangeEmail($data));
    }

    public static function sendOrderMail($name, $email, $route, $order_number){
        $data = [
            'name' => $name,
            'order_number' => $order_number,
            'route' => $route
        ];
        Mail::to($email)->send(new orderMail($data));
    }

    public static function sendForgotPassword($name, $email, $token, $route){
        $data = [
            'name' => $name,
            'email' => $email,
            'token' => $token,
            'route' =>$route
        ];
        Mail::to($email)->send(new ForgotPasswordMail($data));
    }

    public static function sendSupport($name, $email,$ticket_num){
        $data = [
            'name' => $name,
            'email' => $email,
            'ticket_num' => $ticket_num,
        ];
        Mail::to($email)->send(new Contact($data));
    }

    public static function orderDelivered($name, $email,$order_num, $route){
        $data = [
            'name' => $name,
            'email' => $email,
            'order_number' => $order_num,
            'route' => $route
        ];
        Mail::to($email)->send(new orderDelivered($data));
    }

    public static function orderCompleteSeller($name, $email,$order_num, $route){
        $data = [
            'name' => $name,
            'email' => $email,
            'order_number' => $order_num,
            'route' => $route
        ];
        Mail::to($email)->send(new orderCompleteSeller($data));
    }

    public static function orderCompleteBuyer($name, $email,$order_num, $route){
        $data = [
            'name' => $name,
            'email' => $email,
            'order_number' => $order_num,
            'route' => $route
        ];
        Mail::to($email)->send(new orderCompleteBuyer($data));
    }

    public static function orderCancelled($name, $email,$order_num, $route){
        $data = [
            'name' => $name,
            'email' => $email,
            'order_number' => $order_num,
            'route' => $route
        ];
        Mail::to($email)->send(new orderCancelled($data));
    }


    public static function contactSupport($name, $email,$subject,$order_num,$comment,$ticket_num){
        $data = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'order_num' => $order_num,
            'comment' => $comment,
            'ticket_num' => $ticket_num,
        ];
        Mail::to($email)->send(new Support($data));
    }
}
