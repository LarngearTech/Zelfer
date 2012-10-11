<div class="assessments">
	<h2><?php echo $headline; ?></h2>
	<h4><?php echo $description; ?></h4>
	<?php foreach ($items as $item): ?>
	<?php $this->widget('ZAssessmentItem', array(
		'id' => $item['id'],
		'itemPath' => $item['itemPath'],
	));?>
	<?php endforeach; ?>
</div><!-- /assessments -->

