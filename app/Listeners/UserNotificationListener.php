<?php

namespace App\Listeners;

use App\Events\FirebasePushNotificationEvent;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserNotificationListener implements ShouldBroadcast
{

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    public function handle(FirebasePushNotificationEvent $event)
    {
        $this->broadcastOn('hantask', $event->title);
    }

    /**
     * Handle the event.
     */
    public function broadcastOn()
    {
        return ['hantask'];
    }
}
