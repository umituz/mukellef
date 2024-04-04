<?php

namespace App\Services\Database;

use Illuminate\Support\Facades\DB;

class ConnectionService
{
    private static $instance;

    public function __construct()
    {
    }

    /**
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static;

            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                throw new \Exception(__('Unable to connect to the database!'));
            }
        }

        return static::$instance;
    }
}
