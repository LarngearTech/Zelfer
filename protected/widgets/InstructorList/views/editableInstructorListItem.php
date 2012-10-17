<div class="row">
	<div class="span6">
		<?php $this->widget('InstructorListItem', array('instructor'=>$instructor)); ?>
	</div>
	<div class="span3">
		<?php 
		// Allow delete instructor only if the instructor is not the owner of this course
		if ($course->owner_id != $instructor->id)
		{
			echo CHtml::button(
				'Delete',
				array(
					'class'=>'btn btn-danger btn-delete',
					'onclick'=>'deleteInstructor('.$instructor->id.')',
				)
			);
		}
		?>
	</div>
</div>
