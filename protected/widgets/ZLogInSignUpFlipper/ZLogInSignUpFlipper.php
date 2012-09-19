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
	}

	public function run()
	{
		$this->render('ZLogInSignUpFlipper');
	}
}