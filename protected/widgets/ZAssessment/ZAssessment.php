<?php
/**
 * Assessment widget
 */
class ZAssessment extends CWidget
{
	public $headline;

	public $description;

	// $itemIds Array of assessment items (id, xmlPath)
	public $items;


	public function run()
	{
		// user submits data
		if (isset($_POST['AssessmentForm']))
		{
		}

		$this->render('ZAssessment', array(
			'headline' => $this->headline,
			'description' => $this->description,
			'items' => $this->items,
		));
	}
}
