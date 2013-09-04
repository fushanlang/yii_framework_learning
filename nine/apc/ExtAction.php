<?php
class ExtAction extends CAction
{
	/**
	 * Runs the action.
	 * The action method defined in the controller is invoked.
	 * This method is required by {@link CAction}.
	 */
	public function run($params = array())
	{
		$controller=$this->getController();
		$methodName='action'.$this->getId();
		$method=new ReflectionMethod($controller,$methodName);
		if(($n=$method->getNumberOfParameters())>0)
		{
            if(empty($params))
            {
                $params=array();
                foreach($method->getParameters() as $i=>$param)
                {
                    $name=$param->getName();
                    if(isset($_GET[$name]))
                    {
                        if($param->isArray())
                            $params[]=is_array($_GET[$name]) ? $_GET[$name] : array($_GET[$name]);
                        else if(!is_array($_GET[$name]))
                            $params[]=$_GET[$name];
                        else
                            throw new CHttpException(400,Yii::t('yii','Your request is invalid.'));
                    }
                    else if($param->isDefaultValueAvailable())
                        $params[]=$param->getDefaultValue();
                    else
                        throw new CHttpException(400,Yii::t('yii','Your request is invalid.'));
                }
            }
			return $method->invokeArgs($controller,$params);
		}
		else
			return $controller->$methodName();
	}
}
