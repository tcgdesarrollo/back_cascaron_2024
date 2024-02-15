<?php

namespace App\Console\Commands;

use App\Mail\NewUser;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all queue emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Queue::where('failed_times', '>', 120)->update([
            'sent_result' => "120 intentos fallidos por enviar",
            'deleted_at' => Carbon::now()
        ]);
        $now = Carbon::now();
        //si es antes de las 8am o luego de las 7pm, no se envian salvo que sean urgentes
        $hidden_hours = $now->hour < 8 || $now->hour > 19;
        //tampoco lso fines de semana
        $hidden_days = $now->dayOfWeek > 5;
        if ($hidden_days || $hidden_hours) {
            $queues = Queue::where('is_urgent', true)->latest()->take(10)->get();
        } else {
            $queues = Queue::latest()->take(10)->get();
        }
        foreach ($queues as $queue) {
            //establezco el idioma del email
            app()->setLocale($queue->language);
            //si es un nuevo usuario, le envío la contraseña
            if ($queue->type == 'created_user') {
                try {
                    Mail::to($queue->to)->send(new NewUser($queue));
                    $queue->update([
                        'was_sent' => true,
                        'deleted_at' => Carbon::now()
                    ]);
                } catch (\Exception $e) {
                    $queue->update(['sent_result' => $e->getMessage()]);
                    $queue->increment('failed_times');
                    continue;
                }
            }
        }

    }
}
