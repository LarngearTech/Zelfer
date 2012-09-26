<?php
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl.'/js/bootstrap.min.js'
);?>

<h1>Courses|Take</h1>
	<ul class='thumbnails'>
	<?php
		foreach ($userModel->takeCourses as $course){
			//print_r($course);
			echo CHtml::openTag('li', array('class' => 'span3'));
 			$this->widget('CourseThumbnail', array(
										'course'=>$course,
										'css'=>'coursethumbnail'
			));
			echo CHtml::closeTag('li');
		}
	?>
	</ul>
<h1>Courses|Teach</h1>
	<ul class='thumbnails'>
	<?php	
		foreach ($userModel->teachCourses as $course){
			//print_r($course);
			echo CHtml::openTag('li', array('class' => 'span3'));
			$this->widget('CourseThumbnail', array(
										'course'=>$course,
										'css'=>'coursethumbnail'
			));
			echo CHtml::closeTag('li');
                }
        ?>
        </ul>
