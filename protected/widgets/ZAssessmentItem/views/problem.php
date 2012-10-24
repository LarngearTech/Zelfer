<div class="assessment-item" id="assessment-<?php echo $id;?>">
	<h4><?php echo $item['title']; ?></h4>
	<div class="assessment-prompt"><?php echo $item['prompt']; ?></div>
	<div class="assessment-choices">
		<?php foreach ($item['choices'] as $choice): ?>
			<?php echo CHtml::radioButton($id, false, array(
				'value' => $choice['value'],
			));?>
			<?php echo CHtml::label($choice['text'], $id); ?>	
			<div class="clearfix"></div>
		<?php endforeach; ?>
	</div><!-- /assessment-choices -->
</div><!-- /assessment-item -->
