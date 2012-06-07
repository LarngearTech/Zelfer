<?php
$this->breadcrumbs=array(
	'Lectures'=>array('index'),
	'Create'=>array('create', 
				'lectureId'=>$model->id, 
				'chapterId'=>$model->chapter_id, 
				'courseId'=>$model->chapter->course->id,),
	'Step 1',
);?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lecture-step1-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord?'Create':'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

