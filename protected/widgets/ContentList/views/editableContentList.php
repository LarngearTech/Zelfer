<?php
	$cs = Yii::app()->clientScript;
	$cs->registerScript(
		"delete-content-script",
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
			echo 
			'<li id="content_'.$content->id.'" class="'.$class.'">
				<span class=content-prefix>'.$contentPrefix.'</span><span class=content-name>'.$content->name.'</span>
				<span class="edit-panel">
					<a class="btn content-edit"><i class="icon-edit"></i></a>
					<a class="btn content-delete" id="'.$content->id.'" onclick="js:deleteContent('.$content->id.')"><i class="icon-remove"></i></a>
				</span>
			</li>';
		}
	?>
</ul>
