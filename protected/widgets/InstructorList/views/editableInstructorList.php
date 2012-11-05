<?php 
foreach ($course->instructors as $instructor)
{
	echo '<div class="span6">';
	$this->widget($this->itemWidget, 
		array(
		'course'=>$course,
		'instructor'=>$instructor,
		'deleteInstructorHandler'=>$deleteInstructorHandler,
		'update'=>$update,
	));
	echo '</div>';
}
