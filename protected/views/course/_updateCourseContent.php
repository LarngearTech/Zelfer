<div class="edit-content-panel-container">
	<?php
	$this->widget('EditContentPanel',
		array(
			'course'=>$model,
			'addLectureHandler'=>$this->createUrl('course/addLecture'),
			'addChapterHandler'=>$this->createUrl('course/addChapter'),
		)
	);
	?>
<div>
