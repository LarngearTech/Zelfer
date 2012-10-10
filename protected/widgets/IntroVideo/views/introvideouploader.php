<div class="row">
<div class="span9">
	<h2>Introduction Video</h2>
</div>
<div class="span6">
<div class="intro-video-player-container">
<?php 
	$this->widget('IntroVideoPlayer', array('course'=>$course));
?>
</div>
</div>
<div class="span3">
<div>
	<div>Max 10 MB AVI, MP4, WMV</div>
</div>
<div>
<?php
	$this->widget('EAjaxUpload',
		array(
			'id'=>'introVideoFile',
			'config'=>array(
				'action'=>Yii::app()->createUrl('course/changeIntroVideo', array('courseId'=>$course->id)),
				'allowedExtensions'=>array("avi", "wmv", "mp4"),
				'sizeLimit'=> 10*1024*1024,// maximum file size in bytes
				'onComplete'=>"js:function(id, fileName, responseJSON){
					$('.intro-video-player-container').html(responseJSON.html); 
				}",
			)		
		)
	);
?>
</div>
</div>
</div>
