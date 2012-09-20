<?php $this->pageTitle=Yii::app()->name; ?>
<div class="container">
<!--?php $this->widget('EBootstrapCarousel', array(
	'items' => array(
		array(
			'src' => Yii::app()->baseUrl.'/images/banner/1.jpg',
			'caption' => 'Image Caption 1.',
			'body' => 'This is a thumbnail',
		),
		array(
			'src' => Yii::app()->baseUrl.'/images/banner/2.jpg',
			'caption' => 'Image Caption 1.',
			'body' => 'This is a thumbnail',
		),
		array(
			'src' => Yii::app()->baseUrl.'/images/banner/3.jpg',
			'caption' => 'Image Caption 1.',
			'body' => 'This is a thumbnail',
		),
		array(
			'src' => Yii::app()->baseUrl.'/images/banner/4.jpg',
			'caption' => 'Image Caption 1.',
			'body' => 'This is a thumbnail',
		),
		array(
			'src' => Yii::app()->baseUrl.'/images/banner/5.jpg',
			'caption' => 'Image Caption 1.',
			'body' => 'This is a thumbnail',
		),
		array(
			'src' => Yii::app()->baseUrl.'/images/banner/6.jpg',
			'caption' => 'Image Caption 1.',
			'body' => 'This is a thumbnail',
			'active' => true,
		),
	),
	'interval' => 6000,
	'infinite' => false,
	'htmlOptions' => array(),
)); ?-->

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
		echo CHtml::openTag('li', array('class' => 'span4'));
		$this->widget('ext.coursethumbnail.CourseThumbnail', array(
								'course'=>$course,
								'css'=>'thumbnail'
		));
		echo CHtml::closeTag('li');
	}
	echo CHtml::closeTag('ul');
}
?>
</div><!-- /container -->
