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
$display_chapters = array();
foreach ($chapters as $chapter)
{
	$chapIdx++;

	// create chapter title
	$chapter_content = '<h2>'.CHtml::encode($chapter->name).'</h2>';

	// create a lecture list
	$lectIdx = 0;
	foreach ($chapter->lectures as $lecture)
	{
		$lectIdx++;
		$chapter_content = $chapter_content.'<br/>Lecture '.$lectIdx.': '.CHtml::encode($lecture->name).'<br/>';
	}
	$display_chapters[] = array(
		'label' => 'Chapter '.$chapIdx,
		'content' => '<p>'.$chapter_content.'</p>',
		'active' => ($chapIdx == 1)? true: false,
	);
}
// create chapter tabbable navigation
$this->widget('bootstrap.widgets.BootTabbable', array(
	'type'=>'tabs',
	'placement'=>'left', 
	'tabs'=> $display_chapters,
));
?>
