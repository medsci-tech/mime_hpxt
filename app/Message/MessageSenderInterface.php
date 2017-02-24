<?php


namespace App\Message;


interface MessageSenderInterface
{
    public function generateMessageVerify($start = 000000, $end = 999999);

    public function sendMessageVerify($phone, $verify);

    public function sendMessage($phone, $message);

}