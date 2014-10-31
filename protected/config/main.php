<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'WindLife',
	'language'=>'zh_cn',

	// preloading 'log' component
	'preload'=>array('log'),
		
	// autoloading model and component classes
	'import'=>array(
		'application.models.data.*',
		'application.models.form.*',
		'application.components.behaviors.*',
		'application.components.extenders.*',
		'application.components.functions.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'jsjgjf',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'request'=>array(
			'enableCsrfValidation'=>true,
			'enableCookieValidation'=>true
		),
		
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
		    'class'=>'application.components.extenders.UrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				''=>'site/index',
			)
		),		
		
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'defaultRoles'=>array('admin_manage_profile','admin_manage_changepass'),
			'itemTable' => 'wl_authitem',
			'itemChildTable' => 'wl_authitemchild',
			'assignmentTable' => 'wl_authassignment',
		),		
		
		'clientScript'=>array(
			'class'=>'CClientScript',
			'scriptMap' => array(
				//'function.js' => '/scripts/all.js?v=121',
				//'style.css'=>'/css/all.css',
				//'jquery.sc.js'=>'/scripts/all.js?v=121'
			),
		),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=windlife',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'jsjgjf',
			'charset' => 'utf8',
			'tablePrefix' => 'wl_',
			'schemaCachingDuration' => 3600,
		),
		
		/*
		'db'=>array(
				'tablePrefix'=>'',
				'connectionString' => 'pgsql:host=localhost;port=5432;dbname=windlife',
				'username'=>'postgres',
				'password'=>'jsjgjf',
				'charset'=>'UTF8',
				'tablePrefix' => 'wl_',
				'schemaCachingDuration' => 3600,
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				/*
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'profile, trace',
				),
				*/
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'cache'=>array(
			'class'=>'CWinCache',
		),
		/*
		'cache'=>array(
		 	'class'=>'CMemCache',
		 	'servers'=>array(
		 		array('host'=>'192.168.1.60', 'port'=>11211, 'weight'=>60),
		 	),
		 ),	
		 */	
		'cacheManage'=>array(
			'class' => 'application.components.extenders.CacheManage',
		),
		
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'jsjgjf@qq.com',
	),
);