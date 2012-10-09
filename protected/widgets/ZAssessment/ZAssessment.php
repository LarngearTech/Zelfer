<?php
/**
 * Assessment widget
 */
class ZAssessment extends CWidget
{
	//$items  Array of assessment items
	public $items;

	public function run()
	{
		// user submits data
		if (isset($_POST['AssessmentForm']))
		{
		}

		$this->render('ZAssessment', array(
			'items' => $items,
		));
	}
}
