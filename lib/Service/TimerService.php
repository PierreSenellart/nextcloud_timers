<?php
namespace OCA\Timers\Service;

use Exception;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

use OCA\Timers\Db\Timer;
use OCA\Timers\Db\TimerMapper;

class TimerService {
  private $mapper;

  public function __construct(TimerMapper $mapper){
    $this->mapper = $mapper;
  }

  public function findAll() {
    return $this->mapper->findAll();
  }

  private function handleException ($e) {
    if ($e instanceof DoesNotExistException ||
        $e instanceof MultipleObjectsReturnedException) {
      throw new NotFoundException($e->getMessage());
    } else {
      throw $e;
    }
  }

  public function find(int $id) {
    try {
      return $this->mapper->find($id, $userId);
    } catch(Exception $e) {
      $this->handleException($e);
    }
  }
  
  public function create(string $name, int $duration) {
    $timer = new Timer();
    $timer->setName($name);
    $timer->setDuration($duration);
    return $this->mapper->insert($timer);
  }

  public function update(int $id, string $name, int $duration) {
    try {
      $timer = $this->mapper->find($id);
      $timer->setName($name);
      $timer->setDuration($duration);
      $timer->reset();
      return $this->mapper->update($timer);
    } catch(Exception $e) {
      return $this->handleException($e);
    }
  }

    public function delete(int $id) {
      try {
        $timer = $this->mapper->find($id);
        $this->mapper->delete($timer);
        return $timer;
      } catch(Exception $e) {
        return $this->handleException($e);
      }
    }
  
  public function start(int $id) {
    try {
      $timer = $this->mapper->find($id);
      $timer->start();
      return $timer;
    } catch(Exception $e) {
      return $this->handleException($e);
    }
  }
  
  public function pause(int $id) {
    try {
      $timer = $this->mapper->find($id);
      $timer->pause();
      return $timer;
    } catch(Exception $e) {
      return $this->handleException($e);
    }
  }
  
  public function reset(int $id) {
    try {
      $timer = $this->mapper->find($id);
      $timer->reset();
      return $timer;
    } catch(Exception $e) {
      return $this->handleException($e);
    }
  }
}
