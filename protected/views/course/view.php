<?php
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);
?>

<h1><?php echo CHtml::encode($model->name); ?></h1>
<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->instructors[0]->fullname); 
	if (count($model->instructors) > 1)
	{
		echo CHtml::encode(" et al.");
	}?>
</h3>
<br/>
<p class="well"><?php echo CHtml::encode($model->short_description); ?></p>
<?php $this->widget('application.extensions.videojs.EVideoJS', array(
	'options' => array(
		// Unique identifier, is autogenerated by default, useful for jQuery integrations.
		'id' => false,
		// Video and poster width in pixels
		'width' => 640,
		// Video and poster height in pixels
		'height' => 360,
		// Poster image absolute URL
		'poster' => false,
		// Absolute URL of the video in MP4 format
		//'video_mp4' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.mp4',
		// Absolute URL of the video in OGV format
		//'video_ogv' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF',
		// Absolute URL of the video in WebM format
		'video_webm' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.webm',
		// Use Flash fallback player ?
		//'flash_fallback' => true,
		'flash_fallback' => false,
		// Address of custom Flash player to use as fallback
		//'flash_player' => 'swf/ClassXPlayer_v2.swf',
		'flash_player' => false,
		// Show controls ?
		'controls' => true,
		// Preload video content ?
		'preload' => false,
		// Autostart the playback ?
		'autoplay' => false,
		// Show VideoJS support link ?
		'support' => false,
		// Show video download links ?
		'download' => false,
	),
));
?>
<br/>
<div id="course-summary">
	<h2>Course Summary</h2>
	<p class="well"><?php echo CHtml::encode($model->long_description); ?></p>
</div>
<div id="course-instructors">
	<h2>Instructor</h2>
	<ul>
	<?php
		foreach ($model->courseInstructors as $instructorRecord)
		{
			echo '<li>'.$instructorRecord['fullname'].'</li>';
			echo '<li>'.$instructorRecord['instructor_career'].'</li>';
			echo '<li>'.$instructorRecord['instructor_description'].'</li>';
		}
	?>
	</ul>
</div>

<?php
// create contents for each chapter
$chapIdx = 0;
$displayChapters = array();
foreach ($chapters as $chapter)
{
	$chapIdx++;

	// create chapter title
	$chapterContent = '<h2>'.CHtml::encode($chapter->name).'</h2>';

	// create a lecture list
	$lectIdx = 0;
	foreach ($chapter->lectures as $lecture)
	{
		$lectIdx++;
		$chapterContent .= '<br/><h3>Lecture '.$lectIdx.': '.CHtml::encode($lecture->name).'<br/></h3>';
		$chapterContent .= $this->widget('ext.swfobject.ESwfObject', array(
			'id'			=> $lecture->id,
			'width' 		=> '590',
			'height' 		=> '442.5',
			'swfFile'		=> Yii::app()->baseUrl . '/swf/ClassXPlayer_v2.swf',
			'playerVersion'	=> '9.0.0',
			'params'		=> array('menu' => 'false', 'quality' => 'high', 'wmode' => 'transparent'),
			'flashvars'		=> array(),
			'attributes'	=> array(),
		), true);

		$chapterContent .= '<br/><p class="well">
			<span class="downloadlink"><a href=""><img src="images/slide.png"/></a></span>
			<span class="downloadlink"><a href=""><img src="images/video.png"></a></span>
		</p>';
	}
	$displayChapters[] = array(
		'label' => 'Chapter '.$chapIdx,
		'content' => '<p>'.$chapterContent.'</p>',
		'active' => ($chapIdx == 1)? true: false,
	);
}
// create contents of the lecture tab 
$lecturesTab = array(
	'label' => 'Lecture',
	'content' => $this->widget('bootstrap.widgets.BootTabbable', array(
		'type'=>'tabs',
		'placement'=>'left', 
		'tabs'=> $displayChapters,
	), true),
	'active' => true,
);

// create contents of the problem set tab
$problemSetsTab = array(
	'label' => 'Problem Set',
	'content' => 'problemset',
);

// create course tabs including lecture and problem set tabs.
$courseTabs = array($lecturesTab, $problemSetsTab);
$this->widget('bootstrap.widgets.BootTabbable', array(
	'type'=>'tabs',
	'placement' => 'top',
	'tabs' => $courseTabs,
));
?>
