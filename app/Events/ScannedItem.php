<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScannedItem implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $itemId;

  public function __construct($itemId)
  {
      $this->itemId = $itemId;
  }

  public function broadcastOn()
  {
      return ['my-channel'];
  }

  public function broadcastAs()
  {
      return 'my-event';
  }
}
