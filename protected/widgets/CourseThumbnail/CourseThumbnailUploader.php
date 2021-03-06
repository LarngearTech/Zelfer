<?php
class CourseThumbnailUploader extends CWidget{
	public $course;
	public $thumbnailUrl;
	public $courseName;
	public $courseShortDescription;
	public $courseUrl;
	public $css;

	function run(){
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerScriptFile($assets.'/js/coursethumbnailuploader.js');

		// Render widget
		$this->render('coursethumbnailuploader', 
			array(
			'course'=>$this->course,
			'css'=>$this->css
		));
	}
}
?>
