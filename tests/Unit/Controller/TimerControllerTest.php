<?php
namespace OCA\Timers\Tests\Unit\Controller;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;

use OCA\Timers\Controller\TimerController;
use OCA\Timers\Service\NotFoundException;

class TimerControllerTest extends PHPUnit_Framework_TestCase {
  protected $controller;
  protected $service;
  protected $userId = 'john';
  protected $request;

  public function setUp() {
    $this->request = $this->getMockBuilder('OCP\IRequest')->getMock();
    $this->service = $this->getMockBuilder('OCA\Timers\Service\TimerService')
                          ->disableOriginalConstructor()
                          ->getMock();
    $this->controller = new TimerController(
      'timers', $this->request, $this->service, $this->userId
    );
  }

  public function testUpdate() {
    $this->service->expects($this->once())
                  ->method('update')
                  ->with($this->equalTo(3),
                    $this->equalTo('title'),
                    $this->equalTo(42))
                  ->will($this->returnValue(""));

    $result = $this->controller->update(3, 'title', 42);

    $this->assertEquals($result->getData(), "");
  }

  public function testUpdateNotFound() {
    $this->service->expects($this->once())
                  ->method('update')
                  ->will($this->throwException(new NotFoundException()));

    $result = $this->controller->update(3, 'title', 42);

    $this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
  }
}
