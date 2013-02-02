<?php
	$isAdd=false;
	if ($item==null) {
		$isAdd=true;
		$item['title']="";
		$item['answers'][]="";
	}
?>
<div class='question-form-container'>
	<form id='question-form-<?php echo $content->id; ?>'>
		<h3><?php echo Yii::t('site', 'Question'); ?></h3>
			<input id="txt-question-name-<?php echo $content->id; ?>" 
			name="question" type="text" value="<?php echo $item['title']; ?>">
		<h3><?php echo Yii::t('site', 'Answer'); ?></h3>
		<div class="choice-list">
			<input name="answer" type="text" value="<?php echo $item['answers'][0]; ?>"/>
		</div>
	</form>
	<div>
		<input type="button" class="btn btn-primary" onclick="js:addFillInTheBlank(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)" 
		value="<?php echo ($isAdd)?Yii::t('site', 'Add Question'):Yii::t('site', 'Update Question'); ?>"/>
		<input type="button" class="btn btn-danger" onclick="js:deleteQuestion(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)" 
		value="<?php echo Yii::t('site', 'Cancel'); ?>"/>
	</div>
</div>