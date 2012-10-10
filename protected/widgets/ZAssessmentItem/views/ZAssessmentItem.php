<div class="assessment-item">
	<h1><?php echo $item['title']; ?></h1>
	<div class="assessment-prompt"><?php echo $item['prompt']; ?></div>
	<div class="assessment-choices">
		<?php foreach ($item['choices'] as $choice): ?>
			<?php echo CHtml::radioButton($id, false, array(
				'value' => $choice['value'],
			));?>
			<?php echo CHtml::label($choice['text'], $id); ?>	
		<?php endforeach; ?>
	</div><!-- /assessment-choices -->
</div><!-- /assessment-item -->
