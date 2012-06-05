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
	$display_chapters[] = array(
		'label' => 'Chapter '.$i.' '.CHtml::encode($chapter->name),
		'content' => '<p>'.$chapter->name.'</p>',
		'active' => ($i == 1)? true: false,
	);
}
$this->widget('bootstrap.widgets.BootTabbable', array(
	'type'=>'tabs',
	'placement'=>'left', // 'above', 'right', 'below' or 'left'
	'tabs'=> $display_chapters,
));
?>

