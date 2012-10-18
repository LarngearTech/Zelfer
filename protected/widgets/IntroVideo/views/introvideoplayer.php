<?php 
//if (!empty($model->intro_url))
//{
	$introVideoPath = ResourcePath::getIntroVideoBaseUrl().$model->intro_url.'/';
	$this->widget('application.extensions.videojs.EVideoJS', array(
		'options' => array(
			// Unique identifier, is autogenerated by default, useful for jQuery integrations.
			'id' => false,
			// Video and poster width in pixels
			//'width' => 460,
			// Video and poster height in pixels
			//'height' => 258,
			// Poster image absolute URL
			'poster' => false,
			// Absolute URL of the video in MP4 format
			'video_mp4' => $introVideoPath.$model->intro_url.".mp4",
			// Absolute URL of the video in OGV format
			//'video_ogv' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.ogv',
			'video_ogv' => $introVideoPath.$model->intro_url.".ogv",
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
//}
//else
//{
//	echo '<img src="noimage.jpg" width=460 height=258></img>';
//}
?>
