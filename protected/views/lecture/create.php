<?php
$this->breadcrumbs=array(
	'Lectures'=>array('index'),
	'Create',
);
?>

<h1>Create Lecture</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
											'chapterId'=>$chapterId,
											'courseId'=>$courseId,
											'returnAction'=>'create')); ?>
