<?php
/**
 * Created by JetBrains PhpStorm.
 * User: TOM
 * Date: 13-7-23
 * Time: 下午11:47
 * To change this template use File | Settings | File Templates.
 */

Yii::setPathOfAlias('bootstrap', YII_EXTENSIONS.'/yii-bootstrap-2.1.0.r355');
Yii::setPathOfAlias('lessphp', YII_EXTENSIONS.'/lessphp');
return array(
    'name' => 'Web Application',
    'defaultController' => 'site',
    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),

    'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
    'modules'=>array(
        'gii'=>array(
            'generatorPaths'=>array(
                'bootstrap.gii',
            ),
        ),
    ),
    'components'=>array(
        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
        'lessphp'=>array(
            'class'=>'lessphp.components.LessCompiler',
            'paths'=>array(
                'themes/bootstrap/css/styles.less' => 'themes/bootstrap/css/styles.css',
            ),
        ),
    ),
);
