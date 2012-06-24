<?php 

/*
 * Base widget
 *
 * This is the parent widget of all bootstrap widgets.
 * It provides some basic functionallity like the collapse option
 * 
 * 
 * @author Tim Helfensdörfer <tim@visualappeal.de>
 * @version 0.3.0
 * @package widgets.bootstrap
 */
class EBootstrapWidget extends CWidget {
	/*
	 * Collapse the widget
	 */
	public $collapse = false;
	
	/*
	 * Show the widget per default
	 *
	 * If it's set to true the widget is per default open
	 */
	public $collapseShow = false;
	
	/*
	 * Default HTML options
	 */
	public $htmlOptions = array();
	
	/*
	 * Javascript file to include for the collapse plugin
	 *
	 * If its set to false, no file will be included
	 */
	public $collapseJsFile = null;
	
	/*
	 * Init the widget
	 */
	public function init() {
		parent::init();
		
		if ($this->collapse) {
			EBootstrap::mergeClass($this->htmlOptions, array('collapse'));
			if ($this->collapseShow)
				EBootstrap::mergeClass($this->htmlOptions, array('in'));
			
	        if (is_null($this->jsFile)) {
    	        if (Yii::app()->clientScript->isScriptFileRegistered(Yii::app()->baseUrl.'/js/bootstrap.min.js')) {
       	         $jsFile = Yii::app()->baseUrl.'/js/bootstrap.min.js';
       	     }
       	     else {
       	         $jsFile = dirname(__FILE__).'/js/bootstrap.min.js';
       	         $this->jsFile = Yii::app()->getAssetManager()->publish($jsFile);
       	         Yii::app()->clientScript->registerScriptFile($this->jsFile);
       	     }
       	 }
       	 elseif ($this->jsFile !== false) {
       	     if (!Yii::app()->clientScript->isScriptFileRegistered(Yii::app()->baseUrl.'/js/bootstrap.min.js')) {
       	         Yii::app()->clientScript->registerScriptFile($this->jsFile);
       	     }
       	 }

		}
	}
}

?>
