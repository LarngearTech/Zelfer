<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('sortable-script',
	"$(function(){
		$('.content-list').sortable({
			handle : '.handle',
			update : function(){
				var contentList = $('.content-list').sortable();
				var order = $(contentList).sortable('serialize');
				//alert(order.toSource());
				$.ajax({
					url:'".Yii::app()->createUrl('course/changeContentOrder')."',
					data:order,
					dataType:'html',		
					type:'POST',
					update:'".$update."'
				});
			}       
		});
	});",
	CClientScript::POS_HEAD);
?>
<div class='row'>
	<ul class='content-list'>
		<li id='contentRow_0'>test item<a class='handle'>move</a></li>
		<li id='contentRow_1'>test item2<a class='handle'>move</a></li>
		<li id='contentRow_2'>test item3<a class='handle'>move</a></li>
		<li id='contentRow_3'>test item4<a class='handle'>move</a></li>
	</ul>
</div>
<div class='row'>
	<?php 
	echo CHtml::ajaxButton(
		'Add Lecture',
		$addLectureHandler,
		array(
			'type'=>'POST',
			'dataType'=>'html',
			'update'=>$update,
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
			'update'=>$update,
		),
		array(
			'class'=>'btn-add-chapter',
		)
	);
	?>
</div>
