<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('make-sort-script',
	"function makeSortable(){
			$('.content-list').sortable({
				//handle : '.content-handle',
				update : function(){
					var contentList = $('.content-list').sortable();
					var order = $(contentList).sortable('serialize');
					$.ajax({
						url:'".Yii::app()->createUrl('course/changeContentOrder',
							array('courseId'=>$course->id))."',
						data:order,
						dataType:'html',                
						type:'POST',
						success:function(html){
							$('.editable-content-list-container').html(html);
							makeSortable();
						}
					});
				}       
			});
	};
	$(function(){
		makeSortable();
	});",
	CClientScript::POS_END);
?>
<h2><?php echo Yii::t('site', 'Create Content');?></h2>
<div class="well clearfix">
<div class='editable-content-list-container'>
	<?php
	$this->widget('EditableContentList',
		array(
			'course'=>$course,
		)
	);
	?>
</div>
</div><!-- /well -->
<div class='btn-group add-content-panel'>
	<?php 
	echo CHtml::ajaxButton(
		Yii::t('site', 'Add Chapter'),
		$addChapterHandler,
		array(
			'type'=>'POST',
			'dataType'=>'html',
			'data'=>array(
				'courseId'=>$course->id,
			),
			'success'=>'function(html) {
				$(".editable-content-list-container").html(html);
				makeSortable();
				alert(html);
			}'
		),
		array(
			'class'=>'btn btn-add-chapter',
		)
	);
	?>
	<?php 
	echo CHtml::ajaxButton(
		Yii::t('site', 'Add Lecture'),
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
</div>
