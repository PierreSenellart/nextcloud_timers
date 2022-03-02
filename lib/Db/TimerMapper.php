<?php
namespace OCA\Timers\Db;

use OCP\IDBConnection;
use OCP\AppFramework\Db\QBMapper;

class TimerMapper extends QBMapper {
  public function __construct(IDBConnection $db) {
    parent::__construct($db, 'timers', Timer::class);
  }

  public function find(int $id) {
    $qb = $this->db->getQueryBuilder();

    $qb->select('*')
        ->from($this->getTableName())
        ->where(
          $qb->expr()->eq('id', $qb->createNamedParameter($id))
        );

    return $this->findEntity($qb);
  }

  public function findAll() {
    $qb = $this->db>getQueryBuilder();

    $qb->select('*')
        ->from($this->getTableName());

    return $find->findEntities($qb);
  }
}
