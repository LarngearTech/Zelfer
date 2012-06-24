<?php
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Create Course', 'url'=>array('create')),
	array('label'=>'View Course', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);
?>



<h1>Edit Course <?php echo $model->name; ?></h1>
<div class="row">
	<?php echo CHtml::link('Create Lecture', array('lecture/create',
							'lectureId'=>'', 
							'chapterId'=>'1',
							'courseId'=>$model->id));?>
</div>
<div class="row">
	<?php echo CHtml::link('Edit Instructor', array('editInstructor',
							'courseId'=>$model->id));?>
</div>

