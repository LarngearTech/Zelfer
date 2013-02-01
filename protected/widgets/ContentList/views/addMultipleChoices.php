<?php
	$isAdd=false;
	if ($item==null) {
		$isAdd=true;
		$item['title']="";
		$item['answers'][]="";
		$item['choices']=array(
			array("text"=>"", "value"=>"0"),
			array("text"=>"", "value"=>"1"),
			array("text"=>"", "value"=>"2"),
			array("text"=>"", "value"=>"3"),
		);
	}
?>
<div class='question-form-container'>
	<form id='question-form-<?php echo $content->id; ?>'>
		<h3><?php echo Yii::t('site', 'Question'); ?></h3>
			<input id="txt-question-name-<?php echo $content->id; ?>" name="question" type="text"
			value="<?php echo $item['title']; ?>"/>
		<h3><?php echo Yii::t('site', 'Answer'); ?></h3>
		<div class="choice-list">
			<ul>
				<li>
					<input type="radio" <?php if($item['answers'][0]==0){ echo "checked='true'";}?> name="answer" value="<?php echo $item['choices'][0]['value']; ?>">
						<input name="txt-choice" type="text" value="<?php echo $item['choices'][0]['text']; ?>"/>
					</input>
				</li>
				<li>
					<input type="radio" <?php if($item['answers'][0]==1){ echo "checked='true'";}?> name="answer" value="<?php echo $item['choices'][1]['value']; ?>">
						<input name="txt-choice" type="text" value="<?php echo $item['choices'][1]['text']; ?>"/>
					</input>
				</li>
				<li>
					<input type="radio" <?php if($item['answers'][0]==2){ echo "checked='true'";}?> name="answer" value="<?php echo $item['choices'][2]['value']; ?>">
						<input name="txt-choice" type="text" value="<?php echo $item['choices'][2]['text']; ?>"/>
					</input>
				</li>
				<li>
					<input type="radio" <?php if($item['answers'][0]==3){ echo "checked='true'";}?> name="answer" value="<?php echo $item['choices'][3]['value']; ?>">
						<input name="txt-choice" type="text" value="<?php echo $item['choices'][3]['text']; ?>"/>
					</input>
				</li>
			</ul>
		</div>
	</form>
	<div>
		<input type="button" class="btn btn-primary" onclick="js:addMultipleChoices(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)" 
		value="<?php echo ($isAdd)?Yii::t('site', 'Add Question'):Yii::t('site', 'Update Question'); ?>"/>
		<input type="button" class="btn btn-danger" onclick="js:deleteQuestion(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)"
		value="<?php echo Yii::t('site', 'Cancel'); ?>"/>
	</div>
</div>