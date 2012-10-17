<?php
class ContentList extends CWidget{
	public $addLectureHandler;
	public $addChapterHandler;
	public $update;
	function run(){
                // Get assets dir
                $baseDir = dirname(__FILE__);
                $assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

                // Publish required assets
                $cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');
                //$cs->registerScriptFile($assets.'/js/contentList.js');

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
