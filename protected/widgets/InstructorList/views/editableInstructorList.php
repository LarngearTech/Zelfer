<?php
foreach ($course->instructors as $instructor)
{
	$this->widget($this->itemWidget, 
		array(
		'course'=>$course,
		'instructor'=>$instructor,
		'deleteInstructorHandler'=>$deleteInstructorHandler,
		'update'=>$update,
	));
}
?>
