<div class="row">
<div class="span9">
	<h2>Introduction Video</h2>
</div>
<div class="span6">
<div class="intro-video-player-container">
<?php 
$this->widget('application.extensions.videojs.EVideoJS', array(
	'options' => array(
		// Unique identifier, is autogenerated by default, useful for jQuery integrations.
		'id' => false,
		// Video and poster width in pixels
		'width' => 460,
		// Video and poster height in pixels
		'height' => 258,
		// Poster image absolute URL
		'poster' => false,
		// Absolute URL of the video in MP4 format
		'video_mp4' => $course->introUrl.".mp4",
		// Absolute URL of the video in OGV format
		//'video_ogv' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.ogv',
		'video_ogv' => $course->introUrl.".ogv",
		// Absolute URL of the video in WebM format
		//'video_webm' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.webm',
		// Use Flash fallback player ?
		'flash_fallback' => true,
		//'flash_fallback' => false,
		// Address of custom Flash player to use as fallback
		//'flash_player' => 'swf/ClassXPlayer_v2.swf',
		//'flash_player' => false,
		'flash_player' => 'http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf',
		// Show controls ?
		'controls' => true,
		// Preload video content ?
		'preload' => true,
		// Autostart the playback ?
		'autoplay' => false,
		// Show VideoJS support link ?
		'support' => false,
		// Show video download links ?
		'download' => false,
	),
	
));
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
