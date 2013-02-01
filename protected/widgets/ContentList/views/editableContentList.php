<?php
	$cs = Yii::app()->clientScript;
	$cs->registerScript(
		'toggle-edit-panel',
		'$(document).on({
			mouseenter: function() {
				$("> .edit-panel", this).show();
			},
			mouseleave: function() {
				if (!$(this).hasClass("content-editing"))
				{
					$("> .edit-panel", this).hide();
				}
			}
		}, ".content-list li div");',
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
		}
		function deleteContentVideoAndRedirect(contentId, contentPrefix){
			$.ajax({
				url:"'.Yii::app()->createUrl("course/deleteContentVideoAndRedirect").'",
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
		'content-type-selected-handle',
		'function contentTypeSelected(contentId, 
				contentPrefix, 
				contentType)
		{
			$.ajax({
				url:"'.Yii::app()->createUrl('course/contentTypeSelected').'",
				data:{
					contentId:contentId,
					contentPrefix:contentPrefix,
					contentType:contentType
				},
				type:"POST",
				dataType:"html",
				success:function(html){
					$("#edit-content-body-"+contentId).html(html);
					makeSortable();
				}
			});
		}

		function addSupplementaryMaterial(contentId, contentPrefix){
			$.ajax({
				url:"'.Yii::app()->createUrl('course/addSupplementaryMaterial').'",
				type:"POST",
				data:{
					contentId:contentId,
					contentPrefix:contentPrefix,
				},
				dataType:"html",
				success:function(html){
					$("#edit-content-body-"+contentId).html(html);
				}
			});
		}

		function deleteSupplementaryMaterial(contentId, materialName){
			$.ajax({
				url:"'.Yii::app()->createUrl('course/deleteSupplementaryMaterial').'",
				type:"POST",
				data:{
					contentId:contentId,
					materialName:materialName
				},
				dataType:"html",
				success:function(html){
					$("#material-list-"+contentId).html(html);
				}
			});
		}
		',
		CClientScript::POS_END
	);

	$cs->registerScript(
		'toJSON',
		'function toJSON(questionId){
			var o = {};
			var a = $("#question-form-"+questionId).serializeArray();

			$.each(a, function(){
				if (o[this.name] !== undefined) {
            		if (!o[this.name].push) {
                		o[this.name] = [o[this.name]];
            		}
            		o[this.name].push(this.value || "");
        		} else {
            		o[this.name] = this.value || "";
        		}
			});
			return o;			
		}',
		CClientScript::POS_END
	);

	$cs->registerScript(
		'question-handle',
		'function addMultipleChoices(quizId, questionId){
			var json = toJSON(questionId);

			$.ajax({
				url:"'.Yii::app()->createUrl("course/addMultiple").'",
				data:{
					contentId:questionId,
					data:json
				},
				dataType:"html",
				type:"POST",
				success:function(html){
					$("#content_"+quizId).html(html);
					makeSortable();
				}
			});
		}

		function addTrueFalse(quizId, questionId){
			var json = toJSON(questionId);

			$.ajax({
				url:"'.Yii::app()->createUrl("course/addTrueFalse").'",
				data:{
					contentId:questionId,
					data:json
				},
				dataType:"html",
				type:"POST",
				success:function(html){
					$("#content_"+quizId).html(html);
					makeSortable();
				}
			});
		}

		function editQuestion(quizId, questionId){
			$.ajax({
				url:"'.Yii::app()->createUrl("course/editQuestion").'",
				data:{
					contentId:questionId,
				},
				dataType:"html",
				type:"POST",
				success:function(html){
					$("#edit-content-body-"+quizId).html(html);
					makeSortable();
				}
			});
		}

		function deleteQuestion(quizId, questionId){
			$.ajax({
				url:"'.Yii::app()->createUrl("course/deleteQuestion").'",
				data:{
					contentId:questionId,
				},
				dataType:"html",
				type:"POST",
				success:function(html){
					$("#content_"+quizId).html(html);
					makeSortable();
				}
			});
		}
		',
		CClientScript::POS_END
	);
?>

<ul class='content-list'>
<?php
	$chapterId = 0;
	$lectureId = 0;
	$quizId = 0;
	$contentPrefix;
	$class;
	foreach ($contents as $content)
	{
		if ($content->isChapter()
			||$content->isLecture()
			||$content->isQuiz())
		{
			if ($content->isChapter())
			{
				$class = 'editable-chapter';
				$chapterId++;
				$lectureId = 0;
				$quizId = 0;
				$contentPrefix = Yii::t('site', 'Chapter')." ".$chapterId.": ";
			}
			else if($content->isLecture())
			{
				$class = 'editable-lecture';
				$lectureId++;
				$contentPrefix = Yii::t('site', 'Lecture')." ".$lectureId.": ";
			}
			else if ($content->isQuiz())
			{
				$class = 'editable-quiz';
				$quizId++;
				$contentPrefix = Yii::t('site', 'Quiz')." ".$quizId.": ";
			}

			echo '<li id="content_'.$content->id.'" class="'.$class.'">';
			$this->widget('EditableContentListItem',
				array(
					'contentPrefix' => $contentPrefix,
					'content' => $content,
				));
			echo '</li>';
		}
	}
?>
</ul>
