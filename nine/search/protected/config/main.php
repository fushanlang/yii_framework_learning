<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', YII_EXTENSIONS.'/yii-bootstrap-2.1.0.r355');


Yii::setPathOfAlias('bootstrap', YII_EXTENSIONS.'/yii-bootstrap-2.1.0.r355');

// This is the main Web application configuration. Any writable
// application properties can be configured here.

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Yii Framework: Phone Book Demo',

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),

    // application components
    'components'=>array(
        'db'=>array(
            'connectionString'=>'sqlite:protected/data/phonebook.db',
        ),
    ),
);