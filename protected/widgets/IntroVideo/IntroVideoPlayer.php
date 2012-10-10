<?php
class IntroVideoPlayer extends CWidget{
	public $course;

	function run(){
		if ($this->course){
			// Render widget
			echo $this->render('introvideoplayer', array(
				'model'=>$this->course,
			));
		}
		else{
			throw new CException('Course variable must be set');
		}
	}
}
?>
