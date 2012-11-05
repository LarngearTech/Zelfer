<?php
	$cs = Yii::app()->clientScript;
	$cs->registerScript(
		'edit-content-handle',
		'function editContent(contentId, contentPrefix){
			$("#content_"+contentId).addClass("content-editing");
			$.ajax({
				url:"'.Yii::app()->createUrl('course/editContent').'",
				data:{
					contentId:contentId,
					contentPrefix:contentPrefix,
				},
				type:"POST",
				dataType:"html",
				success:function(html){
					$("#content_"+contentId).html(html);
					makeSortable();
				}
			});
		}',
		CClientScript::POS_END
		
	);
	$cs->registerScript(
		"delete-content-handle",
		"function deleteContent(contentId){
			$.ajax({
				url:'".Yii::app()->createUrl('course/deleteContent')."',
				data:{
					courseId:".$courseId.",
					contentId:contentId, 
				},                      
				type:'POST',
				dataType:'html',
				success:function(html){
					$('.editable-content-list-container').html(html);
					makeSortable();
				}
			});
		}",
		CClientScript::POS_END
	);	
?>

<ul class='content-list'>
<?php
	$chapterId=0;
	$lectureId=0;
	$contentPrefix;
	$class;
	foreach($contents as $content)
	{
		if ($content->isChapter())
		{
			$class='editable-chapter';
			$chapterId++;
			$lectureId=0;
			$contentPrefix=Yii::t('site', 'Chapter')." ".$chapterId.": ";
		}
		else
		{
			$class='editable-lecture';
			$lectureId++;
			$contentPrefix=Yii::t('site', 'Lecture')." ".$lectureId.": ";
		}
		echo '<li id="content_'.$content->id.'" class="'.$class.'">';
		$this->widget('EditableContentListItem',
			array(
				'contentPrefix'=>$contentPrefix,
				'content'=>$content,
			));
		echo '</li>';
	}
?>
</ul>
