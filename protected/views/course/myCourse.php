<?php
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl.'/js/bootstrap.min.js'
);
Yii::app()->clientScript->registerScript(
	'toggle-taking-teaching',
	'$("#taking-btn").on("click", function(event) {
		$("#taking-courses").show();
		$("#teaching-courses").hide();
	});
	$("#teaching-btn").on("click", function(event) {
		$("#taking-courses").hide();
		$("#teaching-courses").show();
	});',
	CClientScript::POS_END
);
?>
<div class="container">
	<div class="mycourse-wrapper">
		<div id="mycourse-btn-group" class="btn-group" data-toggle="buttons-radio">
			<button type="button" id="taking-btn" class="btn active"><?php echo Yii::t('site', 'Taking');?></button>
			<button type="button" id="teaching-btn" class="btn"><?php echo Yii::t('site', 'Teaching');?></button>
		</div><!-- btn-group -->
		<div id="taking-courses">
			<ul class='thumbnails'>
				<?php
				foreach ($userModel->take_courses as $course) {
					//print_r($course);
					echo CHtml::openTag('li', array('class' => 'span4'));
 					$this->widget('CourseThumbnail', 
						array(
							'course'=>$course,
							'courseUrl'=>Yii::app()->createUrl('course/inclass',
								array(
									'id'=>$course->id,
								)),
					));
					echo CHtml::closeTag('li');
				}
				echo CHtml::openTag('li', array('class' => 'span4'));
				$this->widget('AddCourseThumbnail', 
					array(
						'redirectUrl'=>$this->createUrl('site/index'),
						'caption'=>'Browse Course'
				));
				echo CHtml::closeTag('li');
				?>
			</ul>
		</div><!-- /taking-courses -->
		<div id="teaching-courses">
			<ul class='thumbnails'>
				<?php	
				foreach ($userModel->teach_courses as $course) {
					//print_r($course);
					echo CHtml::openTag('li', array('class' => 'span4'));
					$this->widget('CourseThumbnail', 
						array(
							'course'=>$course,
							'courseUrl'=>$this->createUrl('course/update', 
								array(
									'courseId'=>$course->id,
								)),
					));
					echo CHtml::closeTag('li');
				}
				echo CHtml::openTag('li', array('class' => 'span4'));
				$this->widget('AddCourseThumbnail',
					array(
			 		 'redirectUrl'=>$this->createUrl('course/create'),
			 		 'caption'=>'Create Course'
				));
			 	echo CHtml::closeTag('li');
				?>
			</ul>
		</div><!-- /teaching-courses -->
	</div><!-- /mycourse-wrapper -->
</div><!-- /container -->
