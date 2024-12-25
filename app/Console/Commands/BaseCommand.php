<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    abstract protected function fetchAndSeed(array $params): void;

    public function handle()
    {
        try {
            $params = $this->options();
            $this->fetchAndSeed($params);
            $this->info('Articles have been fetched and seeded successfully.');
        } catch (\Exception $e) {
            \Log::error("Error: {$e->getMessage()}");
            $this->error("Error: {$e->getMessage()}");
        }
    }
}
