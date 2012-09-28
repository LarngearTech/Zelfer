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

	public function init()
	{
		Yii::app()->getClientScript()->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.widgets.ZLectureStack.assets.css').'/style.css'));
	}

	public function run()
	{
		$this->render('ZLectureStack', array(
			'chapters' => $this->chapters,
		));
	}
}
