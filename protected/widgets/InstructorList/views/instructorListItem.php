<div class="instructor">
	<div class="instructor-header">
		<div class="instructor-image">
			<?php echo CHtml::image($profileImageUrl, 'Image of '.$instructor->fullname, array('class' => '')); ?>
		</div>
		<h2><?php echo $instructor->fullname; ?></h3>
		<h4><?php echo $instructor->career; ?></h4>
	</div>
	<div class="instructor-detail">
		<p><?php echo $instructor->description; ?></p>
	</div>
</div>
