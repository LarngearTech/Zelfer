<?php
/**
 * Log-in and Sign-up widget
 */
require_once(dirname(__FILE__).'/ScriptRegisteringHelper.php');

class ZLogInSignUpFlipper extends CWidget
{
	// $returnUrl used to redirect to course/view after loggin in or signing up
	public $returnUrl;

	// $courseId used for course subscription
	public $courseId;

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
        	Yii::app()->assetManager->publish(dirname(__FILE__).'/assets/css/style.css')
		);
	}

	public function run()
	{
		$this->render('ZLogInSignUpFlipper', array(
			'courseId' => $this->courseId,
			'returnUrl' => $this->returnUrl,
		));
	}
}
