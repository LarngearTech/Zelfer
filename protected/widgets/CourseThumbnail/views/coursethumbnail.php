<a class='coursethumbnail' href=<?php echo $courseUrl?>>
	<div class='thumbnail-img-container'>
		<img src='<?php echo $thumbnailUrl; ?>' alt='Course thumbnail: '.<?php echo CHtml::encode($courseName); ?>/>
	</div>
	<div class='thumbnail-caption-container'>
		<h5><?php echo CHtml::encode($courseName) ?></h5>
		<p><?php echo CHtml::encode($courseShortDescription) ?></p>
	</div>
</a>
