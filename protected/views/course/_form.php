<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short_description'); ?>
		<?php echo $form->textField($model,'short_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'short_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'long_description'); ?>
		<?php echo $form->textField($model,'long_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'long_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id'); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::label('Course\'s thumbnail', false); ?>
		<?php $this->widget('CMultiFileUpload', array(
					'name' => 'thumbnail',
					'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
					'duplicate' => 'Duplicate file!', // useful, i think
					'denied' => 'Invalid file type', // useful, i think
		)); ?>
	</div>

	<div class="row">
		<?php echo CHtml::label('Course\'s introduction', false); ?>
		<?php $this->widget('CMultiFileUpload', array(
					'name' => 'introduction',
					'accept' => 'jpeg|jpg|gif|png|avi|flv|mov|mp4|mts|wmv', // useful for verifying files
					'duplicate' => 'Duplicate file!', // useful, i think
					'denied' => 'Invalid file type', // useful, i think
		)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->
