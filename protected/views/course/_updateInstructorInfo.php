<div class='row'>
	<div class='span6 input-append'>
		<?php 
		$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'name'=>'fullname',
			'sourceUrl'=>$this->createUrl('course/instructorList'),
			'options'=>array(
				'minLength'=>2,
				'showAnim'=>'fold',
				'select'=>'js:function(event,ui){
					$("#instructorId").val(ui.item["id"]);
				}'
			),
		));
		echo CHtml::hiddenField('instructorId', 
				'', 
				array('id'=>'instructorId')
		);
		echo CHtml::ajaxButton('Add',
			$this->createUrl('course/addInstructor'),
			array(
				'data'=>array(
					'courseId'=>$model->id,
					'instructorId'=>'js:$("#instructorId").val()',
				),
				'type'=>'POST',
				'dataType'=>'html',
				'update'=>'#instructor-list-container',
			),
			array(
				'class'=>'btn'
			)
		);
		?>
	</div>
</div>

<div class='row'>
	<div class='span9'>
		<div id='instructor-list-container'>
			<?php 
			$this->widget('EditableInstructorList', 
				array(
				'course'=>$model,
				'deleteInstructorHandler'=>$this->createUrl('course/deleteInstructor'),
				'update'=>'#instructor-list-container',
				'itemWidget'=>'EditableInstructorListItem'
			)); 
			?>
		</div>
	</div>
</div>
