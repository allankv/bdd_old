<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Biodiversity Data Digitizer',
	'charset'=>'iso-8859-1',
	// preloading 'log' component
	'preload'=>array('log'),
	'homeUrl'=>array('/'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',

	),

	//To change default language set this parameter
	//'language'=>'en_us',
	
	// application components	
	'components'=>array(
            
		// uncomment the following to set up database
		'db'=>array(
			'connectionString'=>'pgsql:host=localhost;port=5432;dbname=database','username'=>'postgres','password'=>'bdd_d3s3nv',
		),
		

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute', //Log on file system /protected/runtime/application.log
					'class'=>'CWebLogRoute', //Log via firefox/firebug
					'levels'=>'error, warning, trace, info',
					'categories'=>'system.*',
				),
			),
		),
	
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'loginUrl'=>array('site/logout'),
			'class' => 'WebUser',
			
		),

                'thumb'=>array(
                        'class'=>'ext.CThumbCreator.CThumbCreator',
                        'defaultName' => "bdd",
                        'prefix'=>'img',
                        'suffix'=>time(),
                ),

		//Configuration and base path to translate app's messages and labels 
		'coreMessages'=>array(
                    'basePath'=>'protected/messages',
                ),
                
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'urlBase'=>'webbee@usp.br',
		'adminEmail'=>'webbee@usp.br',
	),
);
