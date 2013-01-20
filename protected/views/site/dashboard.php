<?php $this->pageTitle=Yii::app()->name; ?>
<div class="inprogress-courses-section">
	<div class="container">
		<h1>In Progress Courses</h1>
		<?php foreach ($inprogressCourses as $ipCourse): ?>
			<?php print_r($ipCourse); ?>
			<br />
			<br />
		<?php endforeach; ?>
	</div><!-- /container -->
</div><!-- /inprogress-courses-section -->
<div class="completed-courses-section">
	<div class="container">
		<h1>Completed Courses</h1>
		<?php foreach ($completedCourses as $cCourse): ?>
			<?php print_r($cCourse); ?>
			<br />
			<br />
		<?php endforeach; ?>

	</div><!-- /container -->
</div><!-- /completed-courses-section -->
