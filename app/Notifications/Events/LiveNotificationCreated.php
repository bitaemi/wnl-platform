<?php

namespace App\Notifications\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Notifications\Events\BroadcastNotificationCreated;

class LiveNotificationCreated extends BroadcastNotificationCreated
{
	use InteractsWithSockets;
}