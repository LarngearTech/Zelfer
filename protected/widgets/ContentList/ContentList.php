<?php
class ContentList extends CWidget{
	public $addLectureHandler;
	public $addChapterHandler;
	public $update;
	function run(){
                // Publish required assets
                $cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('contentList',
			array(
				'addLectureHandler'=>$this->addLectureHandler,
				'addChapterHandler'=>$this->addChapterHandler,
				'update'=>$this->update,
			)
		);
	}
}
?>
