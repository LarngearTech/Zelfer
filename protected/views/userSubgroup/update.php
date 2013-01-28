<?php
$this->breadcrumbs=array(
	'User Subgroups'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserSubgroup', 'url'=>array('index')),
	array('label'=>'Create UserSubgroup', 'url'=>array('create')),
	array('label'=>'View UserSubgroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserSubgroup', 'url'=>array('admin')),
);
?>

<h1>Update UserSubgroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>