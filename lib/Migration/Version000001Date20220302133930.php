<?php
namespace OCA\Timers\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version000001Date20220302133930 extends SimpleMigrationStep {
  /**
  * @param IOutput $output
  * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
  * @param array $options
  * @return null|ISchemaWrapper
  */
  public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
      /** @var ISchemaWrapper $schema */
      $schema = $schemaClosure();

      if (!$schema->hasTable('timers')) {
          $table = $schema->createTable('timers');
          $table->addColumn('id', 'integer', [
              'autoincrement' => true,
              'notnull' => true,
          ]);
          $table->addColumn('name', 'string', [
              'notnull' => true,
              'length' => 200
          ]);
          $table->addColumn('duration', 'integer', [
              'notnull' => true,
          ]);
          $table->addColumn('duration_after_pause', 'integer', [
              'notnull' => false,
          ]);
          $table->addColumn('start_time', 'datetime', [
              'notnull' => false
          ]);

          $table->setPrimaryKey(['id']);
      }
      return $schema;
  }
}
