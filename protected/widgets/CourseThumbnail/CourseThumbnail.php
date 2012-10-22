<?php
class CourseThumbnail extends CWidget{
	public $course;
	public $thumbnailUrl;
	public $courseName;
	public $courseShortDescription;
	public $courseUrl;
	public $css;

	// @param string location of assets directory
	// @return default thumbnail url
	function defaultThumbnailUrl($assets)
	{
		return $assets.'/img/default.jpg';
	}

	function run()
	{
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($assets.'/css/coursethumbnail.css');

		// Set parameter for widget 
		// User does not specified course
		if (!$this->course)
		{
			if (!empty($this->thumbnailUrl))
			{
				$this->thumbnailUrl = file_exists(Yii::app()->basePath.'/../..'.$this->thumbnailUrl)?$this->thumbnailUrl:$this->defaultThumbnailUrl($assets);
			}
			else
			{
				$this->thumbnailUrl = $this->defaultThumbnailUrl($assets);
			}
		}
		// User specified course. Give priority to directly specified paramenter's value first, find from $course if isn't given.
		else
		{
			$this->thumbnailUrl		= ($this->thumbnailUrl)?$this->thumbnailUrl:$this->course->thumbnail_url;
			if (empty($this->thumbnailUrl))
			{
				$this->thumbnailUrl	= $this->defaultThumbnailUrl($assets);
			}
			$this->thumbnailUrl		= file_exists(Yii::app()->basePath.'/../..'.$this->thumbnailUrl)?$this->thumbnailUrl:$this->defaultThumbnailUrl($assets);
			$this->courseName		= ($this->courseName)?$this->courseName:$this->course->name;
			$this->courseShortDescription	= ($this->courseShortDescription)?$this->courseShortDescription:$this->course->short_description;
			//$this->courseUrl		= ($this->courseUrl)?$this->courseUrl:Yii::app()->createUrl('course/inclass', array('id' => $this->course->id));
			$this->courseUrl		= ($this->courseUrl)?$this->courseUrl:Yii::app()->createUrl('course/view', array('id' => $this->course->id));
		}

		// Render widget
		echo $this->render('coursethumbnail', array(
							'thumbnailUrl' => $this->thumbnailUrl,
							'courseName' => $this->courseName,
							'courseShortDescription' => $this->courseShortDescription,
							'courseUrl' => $this->courseUrl,
							'css' => $this->css
					));
	}
}
?>
