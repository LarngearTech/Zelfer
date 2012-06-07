<?php

class ESwfObject extends CWidget
{
    public $params;
    public $flashvars;
    public $attributes;
        
    public $swfFile;
    public $width;
    public $height;
    public $playerVersion;
    
    private $expressInstallFile;
    private $newLineJS;
    private $baseUrl;
    private $clientScript;
    
    public $randomID;
	public $id;

    /**
     * Init the extension
     */
    public function init()
    {
        $this->randomID  = '_'.$this->id.date('YdmHis');
        $this->newLineJS = "\n";
        
        parent::init();
    }
    
    /**
    * Publishes the assets
    */
    public function publishAssets()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);
    }
    
    /**
    * Registers the external javascript files
    */
    public function registerClientScripts()
    {
        // add the scripts
        if ($this->baseUrl === '')
            throw new CException(Yii::t('ESwfObject', 'baseUrl must be set. This is done automatically by calling publishAssets()'));

        $this->clientScript = Yii::app()->getClientScript();
        $this->clientScript->registerScriptFile($this->baseUrl.'/swfobject.js');
        
        // set install express url
        $this->expressInstallFile = $this->baseUrl.'/expressInstall.swf';
    }
    
    /**
     * The javascript needed
     */
    protected function createJsCode(){

        $js  = '';
                
        // add the flashvars array
        $js .= 'var flashvars' . $this->randomID . ' = {' . $this->newLineJS;
        
        if ($this->flashvars && is_array($this->flashvars) && count($this->flashvars) > 0)
        {
            $i = 0;
            $t = count($this->flashvars);
            
            foreach($this->flashvars as $index => $value)
            {
                if ( ($i + 1) == $t )
                {
                    $js .= '    ' . $index . ' : ' . '"' . $value . '"' . $this->newLineJS;
                }
                else
                {
                    $js .= '    ' . $index . ' : ' . '"' . $value . '",' . $this->newLineJS;
                }
                
                $i++;
            }
        }
        
        $js .= '}' . $this->newLineJS;
        //--->>>
        
        // add the params array
        $js .= 'var params' . $this->randomID . ' = {' . $this->newLineJS;
        
        if ($this->params && is_array($this->params) && count($this->params) > 0)
        {
            $i = 0;
            $t = count($this->params);
            
            foreach($this->params as $index => $value)
            {
                if ( ($i + 1) == $t )
                {
                    $js .= '    ' . $index . ' : ' . '"' . $value . '"' . $this->newLineJS;
                }
                else
                {
                    $js .= '    ' . $index . ' : ' . '"' . $value . '",' . $this->newLineJS;
                }
                
                $i++;
            }
        }
        
        $js .= '}' . $this->newLineJS;
        //--->>>
        
        // add the attributes array
        $js .= 'var attributes' . $this->randomID . ' = {' . $this->newLineJS;
        
        if ($this->attributes && is_array($this->attributes) && count($this->attributes) > 0)
        {
            $i = 0;
            $t = count($this->attributes);
            
            foreach($this->attributes as $index => $value)
            {
                if ( ($i + 1) == $t )
                {
                    $js .= '    ' . $index . ' : ' . '"' . $value . '"' . $this->newLineJS;
                }
                else
                {
                    $js .= '    ' . $index . ' : ' . '"' . $value . '",' . $this->newLineJS;
                }
                
                $i++;
            }
        }
        
        $js .= '}' . $this->newLineJS;
        //--->>>
        
        // create the swfobject call
        $js .= $this->newLineJS;
        $js .= 'swfobject.embedSWF("' . $this->swfFile . '", "eswfobject_content' . $this->randomID . '", "' . $this->width . '", "' . $this->height . '", "' . $this->playerVersion . '","' . $this->expressInstallFile . '", flashvars' . $this->randomID . ', params' . $this->randomID . ', attributes' . $this->randomID . ');';
        
        return $js;
    }
    
    /**
     * The HTML object to receive the SWF OBJECT content
     */
    public function createHtml(){
        $html = '<div id="eswfobject_content' . $this->randomID . '"></div>';
        return $html;
    }
    
    /**
     * Run the widget
     */
    public function run()
    {
        $this->publishAssets();
        $this->registerClientScripts();

        $js = $this->createJsCode();
        $this->clientScript->registerScript('js_eswfobject' . $this->randomID, $js, CClientScript::POS_HEAD);

        echo( $this->createHtml() );
        
        parent::run();
    }
}
