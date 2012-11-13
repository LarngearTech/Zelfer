<?php

return CMap::mergeArray(
	require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'shared.php'),
	array(
		// configuration for localhost goes here
		'components' => array(
			'db' => array(
				'connectionString' => 'mysql:host=localhost;port=3306;dbname=zelfer',
				'emulatePrepare' => true,
				'username' => 'username_here',
				'password' => 'password_here',
				'charset' => 'utf8',
			),
		),
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params' => array(
			// storage base url
			'storage-base-url' => '/recture',
			'local-storage-enable' => true,
		),
	)
);
