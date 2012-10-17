<div class="span9" id="content-list-container">
	<?php
	$this->widget('ContentList',
		array(
			'addLectureHandler'=>$this->createUrl('course/addLecture'),
			'addChapterHandler'=>$this->createUrl('course/addChapter'),
			'update'=>'#content-list-container',
		)
	);
	?>
<div>
