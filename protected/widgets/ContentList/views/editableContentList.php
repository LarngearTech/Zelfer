<div class='sortable-list-container'>
	<?php
	$this->widget('SortableContentList',
		array('course'=>$course)
	);
	?>
</div>
<div class='row'>
	<?php 
	echo CHtml::ajaxButton(
		'Add Lecture',
		$addLectureHandler,
		array(
			'type'=>'POST',
			'dataType'=>'html',
			'data'=>array(
				'courseId'=>$course->id,
			),
			'success'=>'function(html){
				$(".sortable-list-container").html(html);
				makeSortable();
			}'
		),
		array(
			'class'=>'btn-add-lecture',
		)
	);
	?>
</div>
<div class='row'>
	<?php 
	echo CHtml::ajaxButton(
		'Add Chapter',
		$addChapterHandler,
		array(
			'type'=>'POST',
			'dataType'=>'html',
			'data'=>array(
				'courseId'=>$course->id,
			),
			'update'=>'.sortable-list-container',
		),
		array(
			'class'=>'btn-add-chapter',
		)
	);
	?>
</div>
