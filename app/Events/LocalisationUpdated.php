<?php
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class LocalisationUpdated implements ShouldBroadcast
{
  public $loc;
  public function __construct($loc) { $this->loc = $loc; }
  public function broadcastOn() { return new \Channel('localisations'); }
}
