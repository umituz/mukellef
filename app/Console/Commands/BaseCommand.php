<?php

namespace App\Console\Commands;

use App\Services\Database\ConnectionService;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    public function __construct()
    {
        parent::__construct();

        $this->setupDatabaseConnection();
    }

    protected function setupDatabaseConnection(): void
    {
        try {
            app(ConnectionService::class);
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return;
        }
    }
}
