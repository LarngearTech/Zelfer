<?php
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name,
);
?>

<h1><?php echo CHtml::encode($model->name); ?></h1>
<br/>
<p class="well"><?php echo CHtml::encode($model->description); ?></p>

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
		$chapterContent = $chapterContent.'<br/>Lecture '.$lectIdx.': '.CHtml::encode($lecture->name).'<br/>';
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
