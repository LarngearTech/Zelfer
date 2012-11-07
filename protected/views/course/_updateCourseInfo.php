<div class="well form">
	<?php
	$this->renderPartial('_form', array(
		'model'=>$model,
		'categoryList'=>$categoryList,
	));
	?>
</div>
<div class="well form">
	<?php
	$this->widget('CourseThumbnailUploader', array(
		'course'=>$model,
		'courseUrl'=>'#',
	));
	?>
</div>
<div class="well form">
	<?php
	$this->widget('IntroVideoUploader', array(
		'course'=>$model,
	));
	?>
</div>
