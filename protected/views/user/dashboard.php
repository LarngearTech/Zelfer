<?php $this->pageTitle=Yii::app()->name; ?>
<div class="container">
	<?php $this->renderPartial('_myCourses', array(
		'inprogressCourses' => $inprogressCourses,
		'completedCourses' => $completedCourses,
	));?>
</div><!-- /container -->
