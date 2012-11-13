<?php

// Get AppFog MySql Configuration
$services_json = json_decode(getenv("VCAP_SERVICES"),true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];

return CMap::mergeArray(
	require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'shared.php'),
	array(
		// configuration for AppFog goes here
		'components' => array(
			'db' => array(
				'connectionString' => 'mysql:host='.$mysql_config["hostname"].';port='.$mysql_config["port"].';dbname='.$mysql_config["name"],
				'emulatePrepare' => true,
				'username' => $mysql_config["username"],
				'password' => $mysql_config["password"],
				'charset' => 'utf8',
			),
		),
		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params' => array(
			// storage base url
			'storage-base-url' => 'https://s3-ap-southeast-1.amazonaws.com',
			'local-storage-enable' => false,
		),
	)
);
