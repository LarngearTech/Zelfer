<?php
class EditableContentList extends CWidget{
	public $addLectureHandler;
	public $addChapterHandler;
	public $update;
	function run(){
                // Publish required assets
                $cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('editableContentList',
			array(
				'addLectureHandler'=>$this->addLectureHandler,
				'addChapterHandler'=>$this->addChapterHandler,
				'update'=>$this->update,
			)
		);
	}
}
?>
