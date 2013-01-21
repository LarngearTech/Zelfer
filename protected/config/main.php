<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name' => 'Zelfer',

	// preloading 'log' component
	'preload' => array(
		'log',
//		'bootstrap',
	),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
		'application.extensions.PasswordHash',
		'application.extensions.querypath.*',
		'application.widgets.bootstrap.*',
		'application.widgets.BaseWidget.*',
		'application.widgets.AddCourseThumbnail.*',
		'application.widgets.CourseThumbnail.*',
		'application.widgets.IntroVideo.*',
		'application.widgets.InstructorList.*',
		'application.widgets.ContentList.*',
		'application.widgets.ContentDisplay.*',
		'application.widgets.EAjaxUpload.*',
		'application.widgets.FileUploader.*',
		'application.widgets.ZLogIn.*',
		'application.widgets.ZSignUp.*',
		'application.widgets.ZLogInSignUpFlipper.*',
		'application.widgets.ZLectureStack.*',
		'application.widgets.ZAssessment.*',
		'application.widgets.ZAssessmentItem.*',
	),

	'modules' => array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),

			// twitter bootstrap extension
			'generatorPaths' => array('bootstrap.gii'),
		),
	),

	// application components
	'components' => array(
		'user' => array(
			// enable cookie-based authentication
			'allowAutoLogin' => true,
			'class' => 'WebUser',
		),
		// uncomment the following to enable URLs in path-format
		/*'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),*/
		// uncomment the following to use a SQLite database
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=zelfer',
			'emulatePrepare' => true,
			'username' => 'username_here',
			'password' => 'password_here',
			'charset' => 'utf8',
		),
		'errorHandler' => array(
			// use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class' => 'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		// this is used in contact page
		'adminEmail' => 'webmaster@example.com',
		'phpass' => array(
			'iteration_count_log2' => 8,
			'portable_hashes' => false,
		),
		// user roles
		'admin_user' => 1,
		'normal_user' => 2,
		// user status
		'active_status' => 1,
		'inactive_status' => 2,

		// content type
		'chapter_content' => 0,
		'no_content' => 1,
		'video_content' => 2,
		'quiz_content' => 3,
		'multiple_choice_content' => 4
	),
	'sourceLanguage' => 'en_us',
	'language' => 'th',
);
