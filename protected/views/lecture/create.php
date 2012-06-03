<?php
$this->breadcrumbs=array(
	'Lectures'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Lecture', 'url'=>array('index')),
	array('label'=>'Manage Lecture', 'url'=>array('admin')),
);
?>

<h1>Create Lecture</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>