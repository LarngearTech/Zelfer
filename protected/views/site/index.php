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
foreach ($categories as $category)
{
	// display category name
	echo '
		<br />
		<div class="page-header">
			<h1>'.CHtml::encode($category->name).'</h1>
		</div>';

	// display courses of each category
	echo CHtml::openTag('ul', array('class' => 'thumbnails'));
	foreach ($courses_in_categories[$category->id] as $course) {
		echo CHtml::openTag('li', array('class' => 'span3'));
		echo CHtml::link(
			// image to be linked
			CHtml::image($course->thumbnailUrl, CHtml::encode('Course thumbnail: '.$course->name)),
			// url to course/view?id=course_id
			array('course/view', 'id' => $course->id),
			// class for tag a href
			array('class' => 'thumbnail')
		);
		echo '
		<h5>'.CHtml::encode($course->name).'</h5>
		<p>'.CHtml::encode($course->short_description).'</p>';
		echo CHtml::closeTag('li');
	}
	echo CHtml::closeTag('ul');
}
?>
