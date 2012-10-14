<div class="instructor">
	<div class="instructor-image">
		<?php echo CHtml::image($profileImageUrl, 'Image of '.$instructor->fullname); ?>
	</div>
	<div class="instructor-detail">
		<h2><?php echo $instructor->fullname; ?></h3>
		<h4><?php echo $instructor->career; ?></h4>
		<p><?php echo $instructor->description; ?></p>
	</div>
</div>
