<a class=<?php echo $css; ?> href=<?php echo $courseUrl?>>
	<div id='thumbnail-img-container'>
		<img src=<?php echo $thumbnailUrl; ?> alt='Course thumbnail: '.<?php echo CHtml::encode($courseName); ?>/>
	</div>
	<div id='thumbnail-caption-container'>
		<h5><?php echo CHtml::encode($courseName) ?></h5>
		<p><?php echo CHtml::encode($courseShortDescription) ?></p>
	</div>
</a>
