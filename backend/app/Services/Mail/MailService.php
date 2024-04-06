<?php

namespace App\Services\Mail;

class MailService
{
    public function sendMailByEvent($class, $data): void
    {
        event(new $class($data));
    }
}
