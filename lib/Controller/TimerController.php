<?php
namespace OCA\Timers\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\Timers\Service\TimerService;

class TimerController extends Controller {
  private $service;
  private $userId;

  use Errors;

  public function __construct(string $AppName, IRequest $request,
                              TimerService $service, $UserId){
    parent::__construct($AppName, $request);
    $this->service = $service;
    $this->userId = $UserId;
  }

  /**
    * @NoAdminRequired
    */
  public function index() {
    return new DataResponse($this->service->findAll());
  }
  
  /**
    * @NoAdminRequired
    */
  public function show(int $id) {
    return $this->handleNotFound(function () use ($id) {
      return $this->service->find($id);
    });
  }
  
  public function create(string $name, int $duration) {
    return $this->service->create($name, $duration);
  }

  public function update(int $id, string $name, int $duration) {
    return $this->handleNotFound(function () use ($id, $name, $duration) {
      return $this->service->update($id, $name, $duration);
    });
  }

  public function destroy(int $id) {
    return $this->handleNotFound(function () use ($id) {
      return $this->service->delete($id);
    });
  }

  public function start(int $id) {
    return $this->handleNotFound(function () use ($id) {
      return $this->service->start($id);
    });
  }

  public function pause(int $id) {
    return $this->handleNotFound(function () use ($id) {
      return $this->service->pause($id);
    });
  }

  public function reset(int $id) {
    return $this->handleNotFound(function () use ($id) {
      return $this->service->reset($id);
    });
  }
}
