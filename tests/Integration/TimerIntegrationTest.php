<?php
namespace OCA\Timer\Tests\Integration\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\App;
use PHPUnit_Framework_TestCase;

use OCA\Timers\Db\Timer;

/**
 * @group DB
 */
class TimerIntegrationTest extends PHPUnit_Framework_TestCase {
  private $controller;
  private $mapper;
  private $userId = 'john';

  public function setUp() {
    parent::setUp();
    $app = new App('timers');
    $container = $app->getContainer();

    // only replace the user id
    $container->registerService('UserId', function($c) {
      return $this->userId;
    });

    $this->controller = $container->query(
      'OCA\Timers\Controller\TimerController'
    );

    $this->mapper = $container->query(
      'OCA\Timers\Db\TimerMapper'
    );
  }

  public function testUpdate() {
    $timer = new Timer();
    $timer->setName('foo');
    $timer->setDuration(42);

    $id = $this->mapper->insert($timer)->getId();

    $updatedTimer = Timer::fromRow([
      'id' => $id,
    ]);
    $updatedTimer->setName('bar');
    $updatedTimer->setDuration(1906);
    $updatedTimer->reset();

    $result = $this->controller->update($id, 'bar', 1906);

    $this->assertEquals($updatedTimer, $result->getData());

    $this->mapper->delete($result->getData());
  }
}
