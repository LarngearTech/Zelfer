<?php
/**
 * Assessment widget
 */
class ZAssessment extends CWidget
{
	// $itemIds Array of assessment items 
	public $items;


	public function run()
	{
		// user submits data
		if (isset($_POST['AssessmentForm']))
		{
		}

		$this->render('ZAssessment', array(
			'items' => $this->items,
		));
	}
}
