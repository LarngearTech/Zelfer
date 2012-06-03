<?php
$this->breadcrumbs=array(
	'Assignment Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AssignmentType', 'url'=>array('index')),
	array('label'=>'Create AssignmentType', 'url'=>array('create')),
	array('label'=>'Update AssignmentType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AssignmentType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AssignmentType', 'url'=>array('admin')),
);
?>

<h1>View AssignmentType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
