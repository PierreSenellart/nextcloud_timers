<?php
return [
  'resources' => [
    'timer' => ['url' => '/timers'],
  ],
  'routes' => [
    ['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
    ['name' => 'timer#start', 'url' => '/timers/start/{id}', 'verb' => 'POST'],
    ['name' => 'timer#pause', 'url' => '/timers/pause/{id}', 'verb' => 'POST'],
    ['name' => 'timer#reset', 'url' => '/timers/reset/{id}', 'verb' => 'POST'],
  ],
];
