<div class='question-form-container'>
	<form id='question-form-<?php echo $content->id; ?>'>
		<h3><?php echo Yii::t('site', 'Question'); ?></h3>
			<input id="txt-question-name-<?php echo $content->id; ?>" name="question" type="text"/>
		<h3><?php echo Yii::t('site', 'Answer'); ?></h3>
		<div class="choice-list">
			<ul>
				<li>
					<input type="radio" name="answer" value="true">
						<span>True</span>
					</input>
				</li>
				<li>
					<input type="radio" name="answer" value="false">
						<span>False</span>
					</input>
				</li>
			</ul>
		</div>
	</form>
	<div>
		<input type="button" onclick="js:addTrueFalse(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)" value="<?php echo Yii::t('site', 'Add Question'); ?>"/>
		<input type="button" onclick="js:deleteQuestion(<?php echo $content->parent_id;?>, <?php echo $content->id; ?>)" value="<?php echo Yii::t('site', 'Cancel'); ?>"/>
	</div>
</div>