<?php
$this->breadcrumbs=array(
	'Assignment Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AssignmentType', 'url'=>array('index')),
	array('label'=>'Create AssignmentType', 'url'=>array('create')),
	array('label'=>'View AssignmentType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssignmentType', 'url'=>array('admin')),
);
?>

<h1>Update AssignmentType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>