<?php
class InstructorListItem extends CWidget{
	public $instructor;
	public $profileImageUrl;

	// @param string location of assets directory
	// @return default profile image url
	function defaultProfileImageUrl($assets)
	{
		return $assets.'/img/default.gif';
	}

	function run()
	{
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		//$cs = Yii::app()->getClientScript();
		//$cs->registerCssFile($assets.'/css/coursethumbnail.css');

		if (empty($this->instructor->profile_image_url))
		{
			$this->profileImageUrl = $this->defaultProfileImageUrl($assets);
		}
		else
		{
			if (Yii::app()->params['local-storage-enable'] == true)
			{
				$this->profileImageUrl = $this->instructor->profile_image_url;
			}
			else
			{
				$this->profileImageUrl = Yii::app()->params['storage-base-url'].$this->instructor->profile_image_url;
			}
		}

		// Render widget
		echo $this->render('instructorListItem', array(
			'instructor'=>$this->instructor,
			'profileImageUrl'=>$this->profileImageUrl,
		));
	}
}
?>
