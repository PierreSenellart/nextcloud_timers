<?php
namespace OCA\Timers\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class Timer extends Entity implements JsonSerializable {
  protected $name;
  protected $duration;
  protected $durationAfterPause;
  protected $startTime;

  public function __construct() {
    $this->addType('id','integer');
    $this->reset();
  }

  public function jsonSerialize() {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'duration' => $this->duration,
      'duration_after_pause' => $this->durationAfterPause,
      'start_time' => $this->startTime,
    ];
  }

  public function start() {
    $this->start_time = time();
  }
  
  public function pause() {
    $this->duration_after_pause -= (time() - $this->start_time());
    $this->start_time = NULL;
  }
  
  public function reset() {
    $this->duration_after_pause = $this->duration;
    $this->start_time = NULL;
  }
}
