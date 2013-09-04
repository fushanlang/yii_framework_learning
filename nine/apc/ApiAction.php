<?php
class ApiAction extends CAction
{
    public function run()
    {
        // If you're using a bytecode cache like eAccelerator this method will return FALSE even if there is a properly formatted Docblock. It // looks like the information required by this method gets stripped out by the bytecode cache.
        // eAccelerator 将会删除php文件的注释内容，造成找不到方法
        // Include ExtDirect PHP Helpers
        
        $controllers_folder = Yii::app()->basePath.'/controllers';

        $cache = new ExtDirect_CacheProvider(Yii::app()->runtimePath.'/api_cache.txt');
        $api = new ExtDirect_API();

        $api->setRouterUrl(Yii::app()->baseUrl .'/index.php'); // default
        //$api->setCacheProvider($cache);
        //$api->setNamespace('Ext.ss');
        //$api->setDescriptor('Ext.ss.APIDesc');
        $api->setDefaults(array(
            'autoInclude' => true,
            'basePath' => $controllers_folder,
        ));

        $controllers = CFileHelper::findFiles($controllers_folder, array('fileTypes'=>array('php')));
        $apis = array();
        if(!empty($controllers))
        {
            foreach($controllers as $key => $filename)
            {
               $basename = pathinfo($filename, PATHINFO_BASENAME);
               $apis[] = substr($basename, 0, strlen($basename) - 14);
            }
        }

        $api->add($apis);

        $api->output();

        $_SESSION['ext-direct-state'] = $api->getState();
    }
}
    