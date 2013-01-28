<?php
$this->breadcrumbs=array(
	'User Subgroups'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UserSubgroup', 'url'=>array('index')),
	array('label'=>'Create UserSubgroup', 'url'=>array('create')),
	array('label'=>'Update UserSubgroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserSubgroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserSubgroup', 'url'=>array('admin')),
);
?>

<h1>View UserSubgroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group',
		'name',
	),
)); ?>
