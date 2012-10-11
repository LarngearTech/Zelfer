<?php foreach ($items as $item): ?>
<?php $this->widget('ZAssessmentItem', array(
		'id' => $item['id'],
		'itemPath' => $item['itemPath'],
));?>
<?php endforeach; ?>

