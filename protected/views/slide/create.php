<?php
$this->breadcrumbs=array(
	'Slides'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Slide', 'url'=>array('index')),
	array('label'=>'Manage Slide', 'url'=>array('admin')),
);
?>

<h1>Create Slide</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>