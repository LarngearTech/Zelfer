<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'assignment-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'course_id'); ?>
		<?php echo $form->textField($model,'course_id'); ?>
		<?php echo $form->error($model,'course_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'release_date'); ?>
		<?php echo $form->textField($model,'release_date'); ?>
		<?php echo $form->error($model,'release_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_credit_expiry_date'); ?>
		<?php echo $form->textField($model,'full_credit_expiry_date'); ?>
		<?php echo $form->error($model,'full_credit_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reduced_credit_expiry_date'); ?>
		<?php echo $form->textField($model,'reduced_credit_expiry_date'); ?>
		<?php echo $form->error($model,'reduced_credit_expiry_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reduced_credit_percentage'); ?>
		<?php echo $form->textField($model,'reduced_credit_percentage'); ?>
		<?php echo $form->error($model,'reduced_credit_percentage'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->