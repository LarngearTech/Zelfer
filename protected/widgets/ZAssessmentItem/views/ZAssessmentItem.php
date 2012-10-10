<div class="assessment-item">
	<h1><?php echo $item['title']; ?></h1>
	<span class="assessment-prompt"><?php echo $item['prompt']; ?></span>
	<div class="assessment-choices">
	<?php foreach ($item['choices'] as $choice): ?>
		<?php echo CHtml::radioButton($id, false, array(
			'value' => $choice['value'],
		));?>
		<?php echo $choice['text']; ?>	
	<?php endforeach; ?>
	</div><!-- /assessment-choices -->
</div><!-- /assessment-item -->
