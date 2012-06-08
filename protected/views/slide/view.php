<?php
$this->breadcrumbs=array(
	'Slides'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Slide', 'url'=>array('index')),
	array('label'=>'Create Slide', 'url'=>array('create')),
	array('label'=>'Update Slide', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Slide', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Slide', 'url'=>array('admin')),
);
?>

<h1>View Slide #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'lecture_id',
	),
)); ?>
