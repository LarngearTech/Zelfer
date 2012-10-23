<div class="course-intro-video-uploader">
	<label>Introduction Video</label>
	<div class="intro-video-player-container">
		<?php 
		$this->widget('IntroVideoPlayer', array('course'=>$course));
		?>
	</div>
	<div>Max 10 MB AVI, MP4, WMV</div>
	<?php
	$this->widget('EAjaxUpload', array(
			'id' => 'introVideoFile',
			'config' => array(
				'action' => Yii::app()->createUrl('course/changeIntroVideo', array('courseId'=>$course->id)),
				'allowedExtensions' => array("avi", "mpeg", "mov", "mp4"),
				'sizeLimit' => 10*1024*1024,// maximum file size in bytes
				'onComplete' => "js:function(id, fileName, responseJSON) {
							$('.intro-video-player-container').html(responseJSON.html); 
							}",)		
	));
	?>
</div>
