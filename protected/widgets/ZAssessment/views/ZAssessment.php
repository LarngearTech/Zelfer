<div class="assessments">
<?php echo CHtml::beginForm(); ?>
	<h2><?php echo $headline; ?></h2>
	<h4><?php echo $description; ?></h4>
	<?php foreach ($items as $item): ?>
		<?php $this->widget('ZAssessmentItem', array(
			'id' => $item['id'],
			'itemPath' => $item['itemPath'],
		));?>
	<?php endforeach; ?>
	<?php echo CHtml::submitButton(Yii::t('site', 'Submit'), array('class' => 'btn btn-primary')); ?>
<?php echo CHtml::endForm(); ?>
</div><!-- /assessments -->
