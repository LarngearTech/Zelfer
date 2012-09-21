<?php
/**
 * Log-in and Sign-up widget
 */
require_once(dirname(__FILE__).'/ScriptRegisteringHelper.php');

class ZLogInSignUpFlipper extends CWidget
{
    /**
     * Initializes the log-in widget.
     * This method will initialize required property values.
     */
	public function init()
	{
		parent::init();
		
		ScriptRegisteringHelper::registerScript('jquery.min.js');
		ScriptRegisteringHelper::registerScript('jquery-ui.min.js');
		ScriptRegisteringHelper::registerScript('jquery.flip.min.js');
		ScriptRegisteringHelper::registerScript('flipper.js');
		Yii::app()->clientScript->registerCssFile(
        	Yii::app()->assetManager->publish(dirname(__FILE__).'/css/style.css')
		);
	}

	public function run()
	{
		$this->render('ZLogInSignUpFlipper');
	}
}
