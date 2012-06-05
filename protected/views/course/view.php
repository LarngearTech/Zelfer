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
$i = 0;
$display_chapters = array();
foreach ($chapters as $chapter)
{
	$i++;
	$chapter_content = '';
	foreach ($chapter->lectures as $lecture)
	{
		$chapter_content = $chapter_content.' '.$lecture->name.' ';
	}
	$display_chapters[] = array(
		'label' => 'Chapter '.$i.' '.CHtml::encode($chapter->name),
		'content' => '<p>'.$chapter_content.'</p>',
		'active' => ($i == 1)? true: false,
	);
}
$this->widget('bootstrap.widgets.BootTabbable', array(
	'type'=>'tabs',
	'placement'=>'left', // 'above', 'right', 'below' or 'left'
	'tabs'=> $display_chapters,
));
?>

