<?php
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl.'/js/bootstrap.min.js'
);?>
<div class="container">
	<h1>Courses|Take</h1>
	<ul class='thumbnails'>
		<?php
		foreach ($userModel->takeCourses as $course) {
			//print_r($course);
			echo CHtml::openTag('li', array('class' => 'span3'));
 			$this->widget('CourseThumbnail', array(
							'course'=>$course,
			));
			echo CHtml::closeTag('li');
		}
		echo CHtml::openTag('li', array('class' => 'span3'));
		$this->widget('AddCourseThumbnail', array(
							'redirectUrl'=>$this->createUrl('site/index'),
							'caption'=>'Browse Course'
		));
		echo CHtml::closeTag('li');
		?>
	</ul>
	<h1>Courses|Teach</h1>
	<ul class='thumbnails'>
		<?php	
		foreach ($userModel->teachCourses as $course) {
			//print_r($course);
			echo CHtml::openTag('li', array('class' => 'span3'));
			$this->widget('CourseThumbnail', array(
							'course'=>$course,
			));
			echo CHtml::closeTag('li');
		}
		echo CHtml::openTag('li', array('class' => 'span3'));
		$this->widget('AddCourseThumbnail', array(
	 					 'redirectUrl'=>$this->createUrl('course/create'),
	 					 'caption'=>'Create Course'
		));
	 	echo CHtml::closeTag('li');
		?>
	</ul>
</div><!-- /container -->
