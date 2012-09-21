<?php
class CourseThumbnail extends CWidget{
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
		$cs->registerCssFile($assets.'/css/coursethumbnail.css');

		// Set parameter for widget 
		// User does not specified course
		if (!$this->course) {
			$this->thumbnailUrl = $assets.'/img/default.jpg';
		}
		// User specified course. Give priority to directly specified paramenter's value first, find from $course if isn't given.
		else {
			$this->thumbnailUrl		= ($this->thumbnailUrl)?$this->thumbnailUrl:$this->course->thumbnailUrl;
			$this->thumbnailUrl		= file_exists(Yii::app()->basePath.'/../..'.$this->thumbnailUrl)?$this->thumbnailUrl:$assets.'/img/default.jpg';
			$this->courseName		= ($this->courseName)?$this->courseName:$this->course->name;
			$this->courseShortDescription	= ($this->courseShortDescription)?$this->courseShortDescription:$this->course->short_description;
			$this->courseUrl		= ($this->courseUrl)?$this->courseUrl:Yii::app()->createUrl('course/view', array('id'=>$this->course->id));
		}

		// Render widget
		echo $this->render('coursethumbnail', array(
							'thumbnailUrl'=>$this->thumbnailUrl,
							'courseName'=>$this->courseName,
							'courseShortDescription'=>$this->courseShortDescription,
							'courseUrl'=>$this->courseUrl,
							'css'=>$this->css
					));
	}
}
?>
