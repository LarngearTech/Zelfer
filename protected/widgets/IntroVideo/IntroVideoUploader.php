<?php
class IntroVideoUploader extends CWidget{
	public $course;

	function run(){
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
