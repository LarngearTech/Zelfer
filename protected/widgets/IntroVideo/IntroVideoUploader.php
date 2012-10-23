<?php
class IntroVideoUploader extends CWidget{

	public $course;

	function init()
	{
		// Get assets dir
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($assets.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css');
	}

	function run()
	{
		if ($this->course){
			// Render widget
			echo $this->render('introvideouploader', array(
				'course'=>$this->course,
			));
		}
		else{
			throw new CException('Course variable must be set');
		}
	}
}
?>
