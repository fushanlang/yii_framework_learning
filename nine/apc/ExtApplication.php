<?php
class ExtApplication extends CWebApplication
{
   /**
	 * @return string the ID of the default controller. Defaults to 'site'.
	 */
	public $defaultController = 'site';
	/**
	 * @var mixed the application-wide layout. Defaults to 'main' (relative to {@link getLayoutPath layoutPath}).
	 * If this is false, then no layout will be used.
	 */
	public $layout = false;

    public $postdata = null;
    public $isForm = false;
    public $isUpload = false;
    
    private $_response = null;
    
    private $_controller;

    protected function preinit()
	{
        $this->parseRequest();
    }
    
    public function processRequest()
	{
        if(isset($this->postdata))
        {
            if(isset($this->_response)) return;
            
            $response = null;
            $output = '';
            if(is_array($this->postdata)){
                $response = array();
                foreach($this->postdata as $d){
                        $response[] = $this->rpc($d);
                }
            }else{
                $response = $this->rpc($this->postdata);
            }
            
            if($this->isForm && $this->isUpload){
                $json = json_encode($response);
                $json = preg_replace("/&quot;/", '\\&quot;', $json);
                
                $output .= '<html><body><textarea>';
                $output .= $json;
                $output .= '</textarea></body></html>';
            }else{
                $output = json_encode($response);
            }
            
            if(!$this->isForm) {
                header('Content-Type: text/javascript');
            }

            echo $output;
            Yii::app()->end();
        }
        else
        {
            parent::processRequest();
        }
	}
    
    public function rpc($cdata) 
    {
        $api = new ExtDirect_API();
        $api->setState($_SESSION['ext-direct-state']);

        $classes = $api->getClasses();
        try 
        {
            if(!isset($classes[$cdata->action])){
                throw new Exception('Call to undefined class: ' . $cdata->action);
            }
            
            $class = $cdata->action;
            $method = $cdata->method;
            
            $cconf = $classes[$class];
            $mconf = null;
            
            $classPath = isset($cconf['fullPath']) 
                ? $cconf['fullPath'] 
                : $api->getClassPath($class, $cconf);
                
            require_once($classPath);
            $parsedAPI = $api->getParsedAPI();

            if(!empty($parsedAPI) && isset($parsedAPI['actions'][$class])) {
                foreach($parsedAPI['actions'][$class] as $m) {
                    if($m['name'] === $method) {                            
                        $mconf = $m;
                        $serverMethod = isset($m['serverMethod']) ? $m['serverMethod'] : $method;
                    }
                }
            }
            else {
                // do some very simple reflection on the class to check if the method is allowed
                $rClass = new ReflectionClass($cconf['prefix'] . $class);
                if(!$rClass->hasMethod($method)) {
                    $rMethods = $rClass->getMethods();
                    foreach($rMethods as $rMethod) {
                        if( $rMethod->isPublic() && strpos($rMethod->getName(), 'action')!==false && strcasecmp($rMethod->getName(),'actions')) 
                        {
                            $serverMethod = $rMethod->getName();
                            $mconf = array(
                                'name' => $method,
                                'len' => $rMethod->getNumberOfRequiredParameters(),
                            );                           
                        }
                    }
                    if(!$serverMethod) {
                        throw new Exception("Call to undefined method: $method on class $class");
                    }                        
                } else {
                    $rMethod = $rClass->getMethod($method);
                    if($rMethod->isPublic() && strlen($doc) > 0) {
                         if( $rMethod->isPublic() && strpos($rMethod->getName(), 'action')!==false && strcasecmp($rMethod->getName(),'actions')) 
                         {
                            $serverMethod = $method;
                            $mconf = array(
                                'name' => $method,
                                'len' => $rMethod->getNumberOfRequiredParameters(),
                            );
                            if(!!preg_match('/' . $api->getFormAttribute() . '/', $doc)) {
                                $mconf['formHandler'] = true;
                            }
                        }            
                    }                        
                }
            }
            
            if(!isset($mconf)) {
                throw new Exception("Call to undefined or unallowed method: $method on class $class");
            }
            
            if($this->isForm && (!isset($mconf['formHandler']) || $mconf['formHandler'] !== true)) {
                throw new Exception("Called method $method on class $class is not a form handler");
            }
            
            $params = isset($cdata->data) && is_array($cdata->data) ? $cdata->data : array();
            
            if(count($params) < $mconf['len']) {
                throw new Exception("Not enough required params specified for method: $method on class $class");
            }
            
            $response = array(
                'type' => 'rpc',
                'tid' => $cdata->tid,
                'action' => $class,
                'method' => $method
            );
            
            $response['result'] = $this->runRpcController($class, $serverMethod, $params);
        } 
        catch(Exception $e) 
        {
            $response = array(
                'type' => 'exception',                    
                'tid' => $cdata->tid,
                'message' => $e->getMessage(),
                'where' => $e->getTraceAsString()
            );
        }
        
        //合并错误消息
        if(isset($response['result']) && isset($response['result']['errors']))
        {
        	foreach($response['result']['errors'] as $key => $errors)
        	{
        		if(is_array($errors)) $response['result']['errors'][$key] = implode(',', $errors);
        	}
        }
        
        return $response;
    }
    
    private function parseRequest() 
    {
        if(isset($GLOBALS['HTTP_RAW_POST_DATA'])){
            $this->postdata = json_decode($GLOBALS['HTTP_RAW_POST_DATA']);
        }
        else if(isset($_POST['extAction'])){ // form post
            $this->isForm = true;
            $this->isUpload = $_POST['extUpload'] == 'true';
            
            $request = new BogusPostData();
            $request->action = $_POST['extAction'];
            $request->method = $_POST['extMethod'];
            $request->tid = $_POST['extTID'];
            $request->data = array($_POST, $_FILES);
            
            $this->postdata = $request;
        }
    }
    
    public function runRpcController($controller, $action, $params)
	{
		if(($ca=$this->createController($controller . '/' . $action))!==null)
		{
			list($controller,$actionID)=$ca;
			$oldController=$this->_controller;
			$this->_controller=$controller;
			$controller->init();
			$result = $controller->run($actionID, $params);
			$this->_controller=$oldController;
            return $result;
		}
		else
			throw new CHttpException(404,Yii::t('yii','Unable to resolve the request "{route}".',
				array('{route}'=>$route===''?$this->defaultController:$route)));
	}
}

class BogusPostData {
    public $action;
    public $method;
    public $data;
    public $tid;
}