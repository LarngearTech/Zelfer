<?php
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl.'/js/bootstrap.min.js'
);
Yii::app()->clientScript->registerScript(
	'toggle-taking-courses',
	'$("#inprogress-courses-section").show();
	$("#completed-courses-section").hide();
	$("#inprogress-btn").on("click", function(event) {
		$("#inprogress-courses-section").show();
		$("#completed-courses-section").hide();
	});
	$("#completed-btn").on("click", function(event) {
		$("#inprogress-courses-section").hide();
		$("#completed-courses-section").show();
	});',
	CClientScript::POS_END
);
?>
<div class="mycourses">
	<div id="mycourse-btn-group" class="btn-group" data-toggle="buttons-radio">
		<h1><?php echo Yii::t('site', 'My Courses');?></h1>
		<button type="button" id="inprogress-btn" class="btn active"><?php echo Yii::t('site', 'In Progress');?></button>
		<button type="button" id="completed-btn" class="btn"><?php echo Yii::t('site', 'Completed');?></button>
	</div><!-- btn-group -->
	<div id="inprogress-courses-section">
		<ol class="inprogress-courses">
		<?php foreach ($inprogressCourses as $ipCourse): ?>
			<li class="inprogress-course">
				<a href="#" class="course-link">
					<div class="course-progress" data-width="23%" style="width:23%;"></div>
					<span class="number-progress">23%</span>
					<div class="course-content">
						<h4 class="course-name"><?php echo $ipCourse['name'];?></h4>
						<p class="course-control">Play</p>
					</div>
					<img class="course-icon" src="<?php echo Yii::app()->baseUrl.$ipCourse['thumbnail_url'];?>" width="59"/>
				</a>
			</li>
		<?php endforeach; ?>
		</ol>
	</div><!-- /inprogress-courses-section -->
	<div id="completed-courses-section">
		<ol class="completed-courses">
		<?php foreach ($completedCourses as $cCourse): ?>
			<li class="completed-course">
				<a href="#" class="course-link">
					<div class="course-progress" data-width="100%" style="width:100%;"></div>
					<div class="course-content">
						<h4 class="course-name"><?php echo $cCourse['name'];?></h4>
					</div>
					<img class="course-icon" src="<?php echo Yii::app()->baseUrl.$cCourse['thumbnail_url'];?>" width="59"/>
				</a>
			</li>
		<?php endforeach; ?>
		</ol>
	</div><!-- /completed-courses-section -->
</div><!-- /mycourses -->
