<?php
class EditContentPanel extends CWidget{
	public $course;
	public $addLectureHandler;
	public $addChapterHandler;
	public $addQuizHandler;

	function run(){
                // Publish required assets
                $cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('editContentPanel',
			array(
				'course'=>$this->course,
				'addLectureHandler'=>$this->addLectureHandler,
				'addChapterHandler'=>$this->addChapterHandler,
				'addQuizHandler'=>$this->addQuizHandler,
			)
		);
	}
}
?>
