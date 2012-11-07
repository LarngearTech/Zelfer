<h4>
	<?php echo Yii::t('site', 'Add Content Material'); ?>
</h4>
<div class="content-type-icon-panel">
	<a class="btn content-type-icon-container" 
	href="javascript:void(0);" 
	onclick="js:contentTypeSelected(<?php echo $contentId?>, 'video')">
		<div><i class="icon-film"></i></div>
		<div>Video</div>
	</a>

	<a class="btn content-type-icon-container">	
		<div><i class="icon-play-circle"></i></div>
		<div>Youtube</div>
	</a>

	<a class="btn content-type-icon-container">	
		<div><i class="icon-share"></i></div>
		<div>Presentation</div>
	</a>

	<a class="btn content-type-icon-container">	
		<div><i class="icon-list-alt"></i></div>
		<div>Document</div>
	</a>
</div>
