<?php $this->pageTitle=Yii::app()->name; ?>
<div class="inprogress-courses-section">
	<div class="container">
		<h1>In Progress Courses</h1>
		<?php foreach ($inprogressCourses as $ipCourse): ?>
			<div class="inprogress-course">
				<img src="<?php echo Yii::app()->baseUrl.$ipCourse['thumbnail_url'];?>" />
			</div>
		<?php endforeach; ?>
	</div><!-- /container -->
</div><!-- /inprogress-courses-section -->
<div class="completed-courses-section">
	<div class="container">
		<h1>Completed Courses</h1>
		<?php foreach ($completedCourses as $cCourse): ?>
			<div class="completed-course">
				<img src="<?php echo Yii::app()->baseUrl.$cCourse['thumbnail_url'];?>" />
			</div>
		<?php endforeach; ?>

	</div><!-- /container -->
</div><!-- /completed-courses-section -->
