<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('make-sort-script',
	"function makeSortable(){
			$('.content-list').sortable({
				handle : '.handle',
				update : function(){
					var contentList = $('.content-list').sortable();
					var order = $(contentList).sortable('serialize');
					$.ajax({
						url:'".Yii::app()->createUrl('course/changeContentOrder',
							array('courseId'=>$course->id))."',
						data:order,
						dataType:'html',                
						type:'POST',
					});
				}       
			});
	};
	$(function(){
		makeSortable()
	});",
	CClientScript::POS_HEAD);
?>
<div class='editable-content-list-container'>
	<?php
	$this->widget('EditableContentList',
		array('course'=>$course)
	);
	?>
</div>
<div class='btn-group'>
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
				$(".editable-content-list-container").html(html);
				makeSortable();
			}'
		),
		array(
			'class'=>'btn btn-add-lecture',
		)
	);
	?>
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
			'success'=>'function(html){
				$(".editable-content-list-container").html(html);
				makeSortable();
			}'
		),
		array(
			'class'=>'btn btn-add-chapter',
		)
	);
	?>
</div>
