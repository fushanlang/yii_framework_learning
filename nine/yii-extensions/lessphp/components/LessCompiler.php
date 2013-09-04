<?php

/**
 * LessCompiler class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
require dirname(__FILE__).'/../lib/lessc.inc.php';

/**
 * Less compiler application component.
 * Preload the component to enable auto compiling.
 */
class LessCompiler extends CApplicationComponent {

    /**
     * @var string the base path.
     */
    public $basePath;

    /**
     * @var array the paths for the files to parse.
     */
    public $paths = array();

    /**
     * Initializes the component.
     */
    public function init() {
        if ($this->basePath === null)
            $this->basePath = Yii::getPathOfAlias('webroot');

        if (!file_exists($this->basePath))
            throw new CException(__CLASS__ . ': Failed to initialize compiler. Base path does not exist.');
        
            $this->compile();
    }

    /**
     * Compiles the less files.
     * @throws CException if the source path does not exist
     */
    public function compile() {
        foreach ($this->paths as $lessPath => $cssPath) {
            $fromPath = $this->basePath . '/' . $lessPath;
            $toPath = $this->basePath . '/' . $cssPath;

            try {
                lessc::ccompile($fromPath, $toPath);
            } catch (exception $ex) {
                exit('lessc fatal error:<br />' . $ex->getMessage());
            }
        }
    }

}
