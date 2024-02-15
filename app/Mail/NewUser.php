<?php

namespace App\Mail;

use App\Models\Queue;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

    public $queue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->bcc(['desarrollo@thecloud.group'])
            ->subject(__('user_created') . env('APP_NAME'))
            ->view('mail.user.new_user');
    }
}
