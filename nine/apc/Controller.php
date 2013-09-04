<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $breadcrumbs=array();
    
    private $_action;
    
    public function runAction($action, $params = array())
	{
		$priorAction=$this->_action;
		$this->_action=$action;
		if($this->beforeAction($action))
		{
			$return = $action->run($params);
			$this->afterAction($action);
		}
		$this->_action=$priorAction;
        
        return $return;
	}
    
    public function createAction($actionID, $params = array())
	{
		if($actionID==='')
			$actionID=$this->defaultAction;
		if(method_exists($this,'action'.$actionID) && strcasecmp($actionID,'s')) // we have actions method
			return new ExtAction($this,$actionID, $params);
		else
			return $this->createActionFromMap($this->actions(),$actionID,$actionID);
	}
    
    public function run($actionID, $params = array())
	{
		if(($action=$this->createAction($actionID))!==null)
		{
			if(($parent=$this->getModule())===null)
				$parent=Yii::app();
			if($parent->beforeControllerAction($this,$action))
			{
				$return = $this->runActionWithFilters($action,$this->filters(), $params);
				$parent->afterControllerAction($this,$action);
                return $return;
			}
		}
		else
			$this->missingAction($actionID);
	}
    
    public function runActionWithFilters($action,$filters, $params = array())
	{
		if(empty($filters))
			return $this->runAction($action, $params);
		else
		{
			$priorAction=$this->_action;
			$this->_action=$action;
			$return = CFilterChain::create($this,$action,$filters)->run();
			$this->_action=$priorAction;
            
            return $return;
		}
	}
}