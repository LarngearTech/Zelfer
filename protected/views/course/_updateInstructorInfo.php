<div class="instructors-info-wrapper">
<div class='input-append'>
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
		'htmlOptions' => array(
			'placeholder' => Yii::t('site', 'Type instructor name'),
		),
	));
	echo CHtml::hiddenField('instructorId', 
			'', 
			array('id'=>'instructorId')
	);
	echo CHtml::ajaxButton(Yii::t('site', 'Add'),
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
<div id='instructor-list-container' class="clearfix">
	<?php 
	$this->renderPartial('_editableInstructorList', array(
		'course' => $model,
	));
	?>
</div><!-- instructor-list-container -->
</div><!-- instructor-info-wrapper -->
