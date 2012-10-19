<div class="span9" class="editable-content-list-container">
	<?php
	$this->widget('EditableContentList',
		array(
			'course'=>$model,
			'addLectureHandler'=>$this->createUrl('course/addLecture'),
			'addChapterHandler'=>$this->createUrl('course/addChapter'),
		)
	);
	?>
<div>
