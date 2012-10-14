<?php
/**
 * Assessment widget
 */
class ZAssessment extends CWidget
{
	/* lecture id that this assessment is belong to */
	public $lectureId;
	/* user id of student */
	public $userId;
	/* headline text of this assessment */
	public $headline;
	/* description of this assessment */
	public $description;
	// $itemIds Array of assessment items (id, xmlPath)
	public $items;

	public function run()
	{
		// user submits data
		if (isset($_POST['test-1']))
		{
			echo 'posted!'.$_POST['test-1']; exit();
		}

		$this->render('ZAssessment', array(
			'lectureId' => $this->lectureId,
			'userId' => $this->userId,
			'headline' => $this->headline,
			'description' => $this->description,
			'items' => $this->items,
		));
	}
}
