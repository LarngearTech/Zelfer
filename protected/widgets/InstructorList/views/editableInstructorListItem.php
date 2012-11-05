<div class="instructor-wrapper">
<?php $this->widget('InstructorListItem', array('instructor'=>$instructor)); ?>
<?php 
// Allow delete instructor only if the instructor is not the owner of this course
if ($course->owner_id != $instructor->id)
{
	echo CHtml::button(
		Yii::t('site', 'Delete'),
		array(
			'href'=>'js:void(0);',
			'class' => 'btn btn-danger btn-delete',
			'onclick' => 'js:deleteInstructor('.$instructor->id.');',
		)
	);
}
?>
</div><!-- /instructor-wrapper -->
<?php
	$cs = Yii::app()->clientScript;
	$cs->registerScript('jsDeleteInstructor', 
		'function deleteInstructor(instructorId){
			$.ajax({
				url:"'.Yii::app()->createUrl('course/deleteInstructor').'",
				data:{
					courseId:'.$course->id.', 
					instructorId:instructorId
				},			
				type:"POST",
				dataType:"html",
				success:function(newList){
					$("'.$update.'").html(newList);
				}
			});
		}', 
	CClientScript::POS_END);
?>
