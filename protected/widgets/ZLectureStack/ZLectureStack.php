<?php
/**
 * Lecture stack widget
 */
class ZLectureStack extends CWidget
{
	// Course that this lecture stack belong to
	public $courseModel;

	// Chapters in this course
	public $chapters;

	public function run()
	{
		$this->render('ZLectureStack', array(
			'chapters' => $chapters,
		));
	}
}
