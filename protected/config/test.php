<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
				'connectionString'=>'mysql:host=localhost;dbname=zelfer_test',
				'emulatePrepare' => true,
				'username' => 'username_here',
				'password' => 'password_here',
				'charset' => 'utf8',
			),
		),
	)
);
