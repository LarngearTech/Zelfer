<?php
class EditableContentList extends CWidget{
	public $course;
	public $addLectureHandler;
	public $addChapterHandler;
	public $update;
	function run(){
                // Publish required assets
                $cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('editableContentList',
			array(
				'course'=>$this->course,
				'addLectureHandler'=>$this->addLectureHandler,
				'addChapterHandler'=>$this->addChapterHandler,
				'update'=>$this->update,
			)
		);
	}
}
?>
