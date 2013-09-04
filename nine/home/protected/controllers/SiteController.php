<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends Controller
{
    public $defaultAction='index';
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{


        $client=new SoapClient("http://9.site4test.com/index.php?r=stock/hello");
        echo "<pre>";
        echo "login...\n";
        if($client->login("aaa","bbb")){
            echo  "success888";
        }else{
            echo  "faild";
        }
        echo "fetching [". $client->login("aaa","bbb")."]all contacts\n";
        echo "</pre>";


        Yii::app()->lessphp->init();
         $this->render('index');
	}
}