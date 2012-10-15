<!--form class='form-search'>
	<div class='input-append'>
		<input type='text' class='span2 search-query'/>
		<button type='submit' class='btn'>Search</button>
	</div>
</form-->
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
			'htmlOptions'=>array(
				'id'=>'autocomplete_box',
			)
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
				'update'=>'.instructor-list-container',
			),
			array(
				'id'=>'autocomplete_btn',
				'class'=>'btn'
			)
		);
		?>
	</div>
</div>

<div class='row'>
	<div class='span6'>
		<div class='instructor-list-container'>
			<?php $this->widget('InstructorList', array('instructorList'=>$model->instructors)); ?>
		</div>
	</div>
</div>
