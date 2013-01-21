<div class='question-form-container'>
	<form id='question-form-<?php echo $content->id; ?>'>
		<h3><?php echo Yii::t('site', 'Question'); ?></h3>
			<input id="txt-question-name-<?php echo $content->id; ?>" name="question" type="text"/>
		<h3><?php echo Yii::t('site', 'Answer'); ?></h3>
		<div class="choice-list">
			<ul>
				<li>
					<input type="radio" name="answer" value="0">
						<input name="txt-choice" type="text"/>
					</input>
				</li>
				<li>
					<input type="radio" name="answer" value="1">
						<input name="txt-choice" type="text"/>
					</input>
				</li>
				<li>
					<input type="radio" name="answer" value="2">
						<input name="txt-choice" type="text"/>
					</input>
				</li>
				<li>
					<input type="radio" name="answer" value="3">
						<input name="txt-choice" type="text"/>
					</input>
				</li>
			</ul>
		</div>
	</form>
	<div>
		<input type="button" onclick="js:addMultipleChoices(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)" value="<?php echo Yii::t('site', 'Add Question'); ?>"/>
		<input type="button" onclick="js:deleteQuestion(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)" value="<?php echo Yii::t('site', 'Cancel'); ?>"/>
	</div>
</div>