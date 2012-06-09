<?php
$this->breadcrumbs=array(
	'Slides'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Slide', 'url'=>array('index')),
	array('label'=>'Create Slide', 'url'=>array('create')),
	array('label'=>'View Slide', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Slide', 'url'=>array('admin')),
);
?>

<h1>Update Slide <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>