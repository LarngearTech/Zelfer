<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data',
					'onsubmit'=>'return submitForm();',)
)); ?>

	<p class="note"><?php echo Yii::t('site', 'Fields with');?> <span class="required">*</span> <?php echo Yii::t('site', 'are required.');?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="input-row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="input-row">
		<?php echo $form->labelEx($model,'short_description'); ?>
		<?php echo $form->textField($model,'short_description',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'short_description'); ?>
	</div>

	<div class="input-row">
		<?php echo $form->labelEx($model,'long_description'); ?>
		<?php echo $form->textArea($model,'long_description',array('style'=>'width:500px;resize:none', 'rows'=>10, 'cols'=>40,'maxlength'=>1000)); ?>
		<?php echo $form->error($model,'long_description'); ?>
	</div>

	<div class="input-row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model, 'category_id', $categoryList, array('maxlength'=>255)); ?>
		<?php echo $form->error($model, 'category_id'); ?>
	</div>


	<div class="input-row">
		<?php echo CHtml::label('Course\'s thumbnail', false); ?>
		<?php $this->widget('CMultiFileUpload', array(
					'id' => 'thumbnails',
					'name' => 'thumbnails',
					'accept' => 'jpeg|jpg|gif|png',
					'duplicate' => 'Duplicate file!',
					'denied' => 'Invalid file type',
					'max' => '1',
		)); ?>
	</div>

	<div class="input-row">
		<?php echo CHtml::label('Course\'s introduction', false); ?>
		<?php $this->widget('CMultiFileUpload', array(
					'id' => 'introductions',
					'name' => 'introductions',
					'accept' => 'jpeg|jpg|gif|png|avi|flv|mov|mp4|mts|wmv', 
					'duplicate' => 'Duplicate file!', 
					'denied' => 'Invalid file type',
					'max' => '1',
		)); ?>
	</div>

	<div class="input-row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('style'=>'margin-top:10px', 'onclick'=>'SubmitEncodeForm()')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">

	function submitForm() {
		// Check if both files has been uploaded
		thumbnail = document.forms['course-form'].elements['thumbnails'].value;
		intro = document.forms['course-form'].elements['introductions'].value;
		if (thumbnail == "")
		{
			alert("You haven't chosen thumbnail");
			return false;
		}
		else if (intro == "")
		{
			alert("You haven't chosen introduction video");
			return false;
		}
		return true;
	}
</script>
