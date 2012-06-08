<?php
$this->breadcrumbs=array(
	'Assignment Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AssignmentType', 'url'=>array('index')),
	array('label'=>'Manage AssignmentType', 'url'=>array('admin')),
);
?>

<h1>Create AssignmentType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>