<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class HomeController extends Controller
{
    public $defaultAction='index';

    /**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		echo 'Hello World HOME';
        $this->render('index');
	}
}