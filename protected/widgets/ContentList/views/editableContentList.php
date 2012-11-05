<?php
	$cs = Yii::app()->clientScript;
	$cs->registerScript(
		'edit-content-handle',
		'function editContent(contentId){
			// hide edit icon
			$("#toggle-edit-"+contentId).hide();

			// change to edit mode
			$("#content_"+contentId).addClass("editing");
			$("#txt-content-name-"+contentId).prop("disabled", false);
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
		$this->render('editableContentListItem',
			array(
				'contentPrefix'=>$contentPrefix,
				'content'=>$content,
				'class'=>$class
			));
	}
?>
</ul>
