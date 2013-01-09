<?php

return array(
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	'name' => 'Item Logger',

	// components to preload
	'preload' => array('log'),

	// autoloading model and component classes
	'import' => array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components' => array(
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'db' => array(
			'enableProfiling' => defined('YII_DEBUG') && YII_DEBUG,
			'charset' => 'utf8',
			'tablePrefix'=>'',
			'schemaCachingDuration'=>300,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => defined('YII_DEBUG') && YII_DEBUG,
			//'useStrictParsing'=>true,
			//'appendParams'=>false,
			'rules' => array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),
);