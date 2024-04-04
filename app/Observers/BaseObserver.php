<?php

namespace App\Observers;

use App\Services\Log\Logger;

class BaseObserver
{
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
}
