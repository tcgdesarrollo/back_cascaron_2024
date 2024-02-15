<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = 'del /f "'.storage_path().'\logs\laravel-' . Carbon::today()->format('Y-m-d') . '.log"';
        try {
            exec($path);
        } catch (\Exception $e) {
            $this->comment('Logs failed to clear');
            return false;
        }
        $this->comment('Logs have been cleared!');
        return true;
    }
}
