<?php

namespace App\Services\Log;

use Illuminate\Support\Facades\DB;

class DatabaseLogger implements Logger
{
    public function log($message)
    {
        DB::table('logs')->insert([
            'message' => $message,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
