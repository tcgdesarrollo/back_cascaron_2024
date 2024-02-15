<?php

namespace App\Console\Commands;

use App\Models\Model;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class RunFactory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-factory';

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
        $factories = scandir(database_path('factories'));
        $clean_factories = [];
        $black_list = ['User'];
        Artisan::call('clear:logs');
        foreach ($factories as $factory) {
            if (str_contains($factory, 'Factory')) {
                $item = str_replace('Factory.php', '', $factory);
                if (!in_array($item, $black_list)) {
                    $clean_factories[] = $item;
                }
            }
        }
        foreach ($clean_factories as $factory) {
            try {
                $modelInstance = App::make("App\\Models\\{$factory}");
                $modelInstance::factory(10)->create();
                $this->comment("Corrida la factory del modelo " . $factory);

            } catch (\Exception $e) {
                $this->comment("Fallida la corrida de la factory " . $factory . "Factory");
                Log::debug($e->getMessage());
            }
        }
    }
}
