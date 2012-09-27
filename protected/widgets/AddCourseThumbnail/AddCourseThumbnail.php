<?php
class AddCourseThumbnail extends CWidget{
	public $redirectUrl;
	public $caption;

	function run(){
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($assets.'/css/addcoursethumbnail.css');

		// Render widget
		echo $this->render('addcoursethumbnail', array(
							'addIconUrl'=>$assets.'/img/add.png',
							'redirectUrl'=>$this->redirectUrl,
							'caption'=>$this->caption
					));
	}
}
?>
