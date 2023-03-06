<?php

namespace App\Listeners;

use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        Mail::to('notify@test.test')->send(new NotifyMail($event->data));
        dd($event->data);
    }
}
