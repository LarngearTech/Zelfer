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
	<div id="paginator-control">
		<nav id="paginator_m_left"></nav>
		<nav id="paginator_o_left"></nav>

		<div class="paginator_p_wrap">
			<div class="paginator_p_bloc">

			</div>
		</div>

		<nav id="paginator_o_right"></nav>
		<nav id="paginator_m_right"></nav>
	</div>
	<div class="clearfix"></div>
	<?php echo CHtml::submitButton(Yii::t('site', 'Submit'), array('class' => 'btn btn-primary')); ?>
<?php echo CHtml::endForm(); ?>
</div><!-- /assessments -->

