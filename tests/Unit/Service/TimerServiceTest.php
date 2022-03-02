<?php
namespace OCA\Timers\Tests\Unit\Service;

use PHPUnit_Framework_TestCase;

use OCP\AppFramework\Db\DoesNotExistException;

use OCA\Timers\Db\Timer;
use OCA\Timers\Service\TimerService;

class TimerServiceTest extends PHPUnit_Framework_TestCase {
  private $service;
  private $mapper;
  private $userId = 'john';

  public function setUp() {
    $this->mapper = $this->getMockBuilder('OCA\Timers\Db\TimerMapper')
                         ->disableOriginalConstructor()
                         ->getMock();
    $this->service = new TimerService($this->mapper);
  }

  public function testUpdate() {
    $timer = Timer::fromRow([
      'id' => 3,
      'name' => 'foo',
      'duration' => 42
    ]);
    $this->mapper->expects($this->once())
                 ->method('find')
                 ->with($this->equalTo(3))
                 ->will($this->returnValue($timer));

    $updatedNote = Timer::fromRow(['id' => 3]);
    $updatedNote->setName('bar');
    $updatedNote->setDuration(1906);
    $updatedNote->reset();
    $this->mapper->expects($this->once())
                 ->method('update')
                 ->with($this->equalTo($updatedNote))
                 ->will($this->returnValue($updatedNote));

    $result = $this->service->update(3, 'bar', 1906);

    $this->assertEquals($updatedNote, $result);
  }


  /**
   * @expectedException OCA\Timers\Service\NotFoundException
   */
  public function testUpdateNotFound() {
    // test the correct status code if no note is found
    $this->mapper->expects($this->once())
                 ->method('find')
                 ->with($this->equalTo(3))
                 ->will($this->throwException(new DoesNotExistException('')));

    $this->service->update(3, 'title', 42);
  }

}
