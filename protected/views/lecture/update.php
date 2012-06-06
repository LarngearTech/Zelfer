<?php
$this->breadcrumbs=array(
	'Lectures'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Lecture', 'url'=>array('index')),
	array('label'=>'Create Lecture', 'url'=>array('create')),
	array('label'=>'View Lecture', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Lecture', 'url'=>array('admin')),
);
?>

<h1>Update Lecture <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 
										'chapterId'=>$model->chapter->id, 
										'courseId'=>$model->chapter->course->id,)); ?>
