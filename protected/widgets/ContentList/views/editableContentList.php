<?php
	$cs = Yii::app()->clientScript;
	$cs->registerScript(
		'toggle-edit-panel',
		'$(document).on({
			mouseenter: function() {
				$(".edit-panel", this).show();
			},
			mouseleave: function() {
				if (!$(this).hasClass("content-editing"))
				{
					$(".edit-panel", this).hide();
				}
			}
		}, ".content-list li");',
		CClientScript::POS_END
	);
	$cs->registerScript(
		'update-content-item-ui',
		'function updateContentItemUi(contentId, html){
			$("#content_"+contentId).html(html).removeClass("content-editing");
			makeSortable();
		}',
		CClientScript::POS_END
	);
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
		'commit-content-handle',
		'function commitContent(contentId, contentPrefix){
			$.ajax({
				url:"'.Yii::app()->createUrl('course/commitContent').'",
				data:{
					contentId:contentId,
					contentName:$("#txt-content-name-"+contentId).val(),
					contentPrefix:contentPrefix,
				},
				type:"POST",
				dataType:"html",
				success:function(html){
					updateContentItemUi(contentId, html);
				}
			});
		}',
		CClientScript::POS_END 
	);
	$cs->registerScript(
		'cancel-edit-content-handle',
		'function cancelEditContent(contentId, contentPrefix){
			$.ajax({
				url:"'.Yii::app()->createUrl('course/cancelEditContent').'",
				data:{
					contentId:contentId,
					contentPrefix:contentPrefix,
				},
				type:"POST",
				dataType:"html",
				success:function(html){
					$("#content_"+contentId).html(html).removeClass("content-editing");
					makeSortable();
				}
			});
		}',
		CClientScript::POS_END
	);
	$cs->registerScript(
		'delete-content-handle',
		'function deleteContent(contentId){
			$.ajax({
				url:"'.Yii::app()->createUrl("course/deleteContent").'",
				data:{
					courseId:'.$courseId.',
					contentId:contentId, 
				},                      
				type:"POST",
				dataType:"html",
				success:function(html){
					$(".editable-content-list-container").html(html);
					makeSortable();
				}
			});
		}',
		CClientScript::POS_END
	);	
	$cs->registerScript(
		'content-type-selected-handle',
		'function contentTypeSelected(contentId, contentType){
			$.ajax({
				url:"'.Yii::app()->createUrl('course/contentTypeSelected').'",
				data:{
					contentId:contentId,
					contentType:contentType
				},
				type:"POST",
				dataType:"html",
				success:function(html){
					$("#edit-content-body-"+contentId).html(html);
					makeSortable();
				}
			});
		}',
		CClientScript::POS_END
	);
?>

<ul class='content-list'>
<?php
	$chapterId = 0;
	$lectureId = 0;
	$contentPrefix;
	$class;
	foreach ($contents as $content)
	{
		if ($content->isChapter())
		{
			$class = 'editable-chapter';
			$chapterId++;
			$lectureId = 0;
			$contentPrefix = Yii::t('site', 'Chapter')." ".$chapterId.": ";
		}
		else
		{
			$class = 'editable-lecture';
			$lectureId++;
			$contentPrefix = Yii::t('site', 'Lecture')." ".$lectureId.": ";
		}
		echo '<li id="content_'.$content->id.'" class="'.$class.'">';
		$this->widget('EditableContentListItem',
			array(
				'contentPrefix' => $contentPrefix,
				'content' => $content,
			));
		echo '</li>';
	}
?>
</ul>
