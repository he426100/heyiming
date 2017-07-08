<?php
return [
	'db' => [
		'db_host' => 'localhost',
		'db_name' => 'fulaigo',
		'db_user' => 'fulaigo',
		'db_pass' => 'fulaigo',
		'prefix' => 'ecs_',
	],

	'redis' => [
		'host' => '127.0.0.1',
		'port' => '6379',
		'timeout' => 5,
		'pass' => '',
		'prefix' => 'fulaigo',
		'expire' => 0  //默认永不过期
	],

	'defaultController' => 'Index',
	'defaultAction' => 'index',

	'timezone' => 'PRC',
];