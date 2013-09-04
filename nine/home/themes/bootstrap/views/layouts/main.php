<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
    <script type="text/javascript"  src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.soap.js" ></script>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Contact', 'url'=>array('/site/contact')),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
    ),
    'htmlOptions'=>array(
        'id'=>'MainNav',
    )
)); ?>

<div class=" container-fluid" id="page">
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span2">
                    <ul class="nav nav-list">
                        <li class="nav-header">
                            List header
                        </li>
                        <li class="active">
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="#">Library</a>
                        </li>
                        <li>
                            <a href="#">Applications</a>
                        </li>
                        <li class="nav-header">
                            Another list header
                        </li>
                        <li>
                            <a href="#">Profile</a>
                        </li>
                        <li>
                            <a href="#">Settings</a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="#">Help</a>
                        </li>
                    </ul>
                </div>
                <div class="span6">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#">Home</a>
                        </li>
                        <li>
                            <a href="#">Profile</a>
                        </li>
                        <li class="disabled">
                            <a href="#">Messages</a>
                        </li>
                        <li class="dropdown pull-right">
                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Dropdown<strong class="caret"></strong></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">Action</a>
                                </li>
                                <li>
                                    <a href="#">Another action</a>
                                </li>
                                <li>
                                    <a href="#">Something else here</a>
                                </li>
                                <li class="divider">
                                </li>
                                <li>
                                    <a href="#">Separated link</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="span4">
                    <div class="btn-group">
                        <button class="btn" type="button"><em class="icon-align-left"></em></button> <button class="btn" type="button"><em class="icon-align-center"></em></button> <button class="btn" type="button"><em class="icon-align-right"></em></button> <button class="btn" type="button"><em class="icon-align-justify"></em></button>
                    </div>
                </div>
            </div>
            <div class="hero-unit">
                <h1>
                    Hello, world!
                </h1>
                <p>
                    This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.
                </p>
                <p>
                    <a class="btn btn-primary btn-large" href="#">Learn more »</a>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $.soap({
            url: 'http://9.site4test.com/index.php?r=stock/hello/',
            method: 'login',

            params: {

            },

            success: function (soapResponse) {
                // do stuff with soapResponse
                // if you want to have the response as JSON use soapResponse.toJSON();
                // or soapResponse.toString() to get XML string
                // or soapResponse.toXML() to get XML DOM
                alert(soapResponse.toString());
            },
            error: function (SOAPResponse) {
                // show error
                alert(SOAPResponse.toString()+"--error");
            }
        });
    });
</script>
</body>
</html>
