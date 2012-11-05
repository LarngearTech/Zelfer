<div id="course-instructors">
	<?php $this->widget('EditableInstructorList', array(
			'course' => $course,
			'deleteInstructorHandler' => $this->createUrl('course/deleteInstructor'),
			'update' => '#instructor-list-container',
			'itemWidget' => 'EditableInstructorListItem',
	));?>

</div><!-- /course-instructors -->
