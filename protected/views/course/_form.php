<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data',
							'onsubmit'=>'return submitEncodeForm();',)
)); ?>

	<p class="note"><?php echo Yii::t('site', 'Fields with');?> <span class="required">*</span> <?php echo Yii::t('site', 'are required.');?></p>

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
		<?php echo $form->dropDownList($model, 'category_id', $categoryList, array('maxlength'=>255)); ?>
		<?php echo $form->error($model, 'category_id'); ?>
	</div>

	<div>
		<table id='instructorTable'>
			<tr><td><?php echo CHtml::label('Instructor Name', false) ?></td></tr>
		</table>
		<input type="hidden" id="instructorId"/>
		<?php echo CHtml::label('Instructors'.'<span class="required">*</span>', false) ?>
		<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'id'	=> 'instructor',
							'name'	=> 'instructor',
							'source'=> $this->createUrl('course/instructorList'),
							'options'=>array(
										'showAnim'=>'fold',
     									'select'=>"js: function(event, ui) {
															$('#instructorId').val(ui.item.id);
														}",
     									'change'=>"js: function(event, ui) {
															$('#instructor').val('');
															$('#instructorId').val('');
														}"
										),
							'htmlOptions'=>array('size'=>60,
												'maxlength'=>255,
												'autocomplete'=>'off'),
            ));
		?>
		<?php
			echo CHtml::button("Add instructor", array('onclick'=>'addInstructor()'));
		?>
	</div>
	<div class="row">
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

	<div class="row">
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
	function addInstructor()
	{
		if ($('#instructorId').val() != "")
		{
			table = document.getElementById('instructorTable');
			newRow = table.insertRow(table.rows.length);
			nameCell = newRow.insertCell(0);
			nameCell.innerHTML = $('#instructor').val();

			newInstructor 	= document.createElement("input");
			newInstructor.nodeValue = $('#instructorId').val();
			type			= document.createAttribute("type");
			type.nodeValue	= "hidden";
			newInstructor.setAttributeNode(type);
			document.forms['course-form'].appendChild(newInstructor);
		}
	}
	function submitEncodeForm() {
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

		document.encode-form.submit();
	}
</script>
