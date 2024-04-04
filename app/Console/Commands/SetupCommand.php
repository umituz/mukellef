<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Artisan;

/**
 * Class SetupCommand
 */
class SetupCommand extends BaseCommand
{
    protected $signature = 'setup';

    protected $description = 'Setup data for project';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Setup process started...');

        $progressBar = $this->output->createProgressBar(1);
        $progressBar->start();

        try {
            $this->performStepOne();
            $progressBar->advance();

            $progressBar->finish();
            $this->info("\nSetup process completed successfully!");
        } catch (\Exception $e) {
            $progressBar->finish();
            $this->error("\nSetup process failed: " . $e->getMessage());
            return;
        }

    }

    private function performStepOne()
    {
        Artisan::call('migrate:fresh', ['--seed' => true]);
    }
}
