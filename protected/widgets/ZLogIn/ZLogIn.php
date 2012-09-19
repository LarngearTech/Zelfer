<?php
/**
 * Log-in widget
 */
class ZLogIn extends CWidget
{
    /**
     * Initializes the log-in widget.
	 * This method will initialize required property values.
	 */ 
	public function init()
	{
		parent::init();

	}

	public function run()
	{
		$this->render('ZLogIn');
	}
}

?>
