<?php
class CourseThumbnail extends CWidget{
	public $course;
	public $thumbnailUrl;
	public $courseName;
	public $courseShortDescription;
	public $courseUrl;
	public $css;

	function run(){
		// Render widget
		echo $this->render('uploadcoursethumbnail', array(
							'thumbnailUrl'=>$this->thumbnailUrl,
							'courseName'=>$this->courseName,
							'courseShortDescription'=>$this->courseShortDescription,
							'courseUrl'=>$this->courseUrl,
							'css'=>$this->css
					));
	}
}
?>
