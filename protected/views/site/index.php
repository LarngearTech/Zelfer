<?php $this->pageTitle=Yii::app()->name; ?>

<?php $this->widget('bootstrap.widgets.BootCarousel', array(
	'items'=>array(
		array('image'=>'http://placehold.it/770x400&text=First+thumbnail', 'label'=>'First Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
		array('image'=>'http://placehold.it/770x400&text=Second+thumbnail', 'label'=>'Second Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
		array('image'=>'http://placehold.it/770x400&text=Third+thumbnail', 'label'=>'Third Thumbnail label', 'caption'=>'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.'),
	),
)); ?>

<?php 

// category sections
foreach ($categories as $category) {
	echo '
	<br />
<div class="page-header">
	<h1>'.$category->name.'</h1>
</div>';
	echo '
<ul class="thumbnails">';

	// display courses of each category
	foreach ($courses_in_categories[$category->id] as $course) {
		echo '
	<li class="span3">';
		echo CHtml::link(
			// image to be linked
			CHtml::image($course->thumbnailUrl, 'Course thumbnail: '.$course->name),
			// url to course/view?id=course_id
			array('course/view', 'id' => $course->id),
			// class for tag a href
			array('class' => 'thumbnail')
		);
		echo '
		<h5>'.$course->name.'</h5>
		<p>'.$course->description.'</p>
	</li>';
	}
	echo '</ul>';
}
?>
