<?php

class StockController extends CController implements IWebServiceProvider
{
    /**
     * Declares the 'phonebook' Web service action.
     */
    public function actions()
    {
        return array(
            'hello'=>array(
                'class'=>'CWebServiceAction',
            ),
        );
    }

    /**
     * This is the default action that displays the phonebook Flex client.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * This action serves as a SOAP client to test the phonebook Web service.
     */
    public function actionTest()
    {

    }

    /**
     * This method is required by IWebServiceProvider.
     * It makes sure the user is logged in before making changes to data.
     * @param CWebService the currently requested Web service.
     * @return boolean whether the remote method should be executed.
     */
    public function beforeWebMethod($service)
    {

            return true;

    }

    /**
     * This method is required by IWebServiceProvider.
     * @param CWebService the currently requested Web service.
     */
    public function afterWebMethod($service)
    {
    }

    /*** The following methods are Web service APIs ***/

    /**
     * @param string username
     * @param string password
     * @return string
     * @soap
     */
    public function login($username,$password)
    {
        return "dddddddddddddddddddd";

    }


}