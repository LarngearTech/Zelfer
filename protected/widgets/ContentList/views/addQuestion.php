<div class="add-question-title">
	<?php echo Yii::t('site', 'Choose Question Type'); ?>
</div>
<div class="content-type-icon-panel">
	<a class="btn content-type-icon-container" 
	href="javascript:void(0);" 
	onclick="js:contentTypeSelected(<?php echo $content->id?>, 
		'<?php echo $contentPrefix; ?>', 
		'<?php echo Yii::app()->params["multiple_choice_content"]; ?>')">
		<div><i class="icon-film"></i></div>
		<div><?php echo Yii::t('site', 'Multiple Choices'); ?></div>
	</a>
	
	<a class="btn content-type-icon-container" 
	href="javascript:void(0);" 
	onclick="js:contentTypeSelected(<?php echo $content->id?>, 
		'<?php echo $contentPrefix; ?>', 
		'<?php echo Yii::app()->params["true_false_content"]; ?>')">
		<div><i class="icon-film"></i></div>
		<div><?php echo Yii::t('site', 'True or False'); ?></div>
	</a>

	<a class="btn content-type-icon-container" 
	href="javascript:void(0);" 
	onclick="js:contentTypeSelected(<?php echo $content->id?>, 
		'<?php echo $contentPrefix; ?>', '<?php ?>')">
		<div><i class="icon-film"></i></div>
		<div><?php echo Yii::t('site', 'Fill in the blank'); ?></div>
	</a>
</div>

<?php
$questions = $content->childContents;
if (sizeof($questions)>0)
{
?>
<div class="question-list">
	<div class="add-question-title">
		<?php echo Yii::t('site', 'Question List'); ?>
	</div>
	<ul>
	<?php
	
	$i=1;
	foreach ($questions as $question)
	{
	?>
		<li>
			<div class="question">
				<span><?php echo $i;?>:</span>
				<span><?php echo $question->name; ?></span>
				<span class="edit-panel">
					<a class="btn content-edit" 
					onclick="js:editQuestion(<?php echo $question->parent_id;?>, <?php echo $question->id; ?>)">
						<i class="icon-pencil"></i>
					</a>
					<a class="btn content-delete" 
					onclick="js:deleteQuestion(<?php echo $question->parent_id;?>, <?php echo $question->id; ?>)">
						<i class="icon-trash"></i>
					</a>
				</span>
			</div>
		</li>
	<?php
		$i++;
	}
	?>
	</ul>
</div>
<?php
}
?>

