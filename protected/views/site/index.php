<?php $this->pageTitle=Yii::app()->name; ?>
<div class="container">
	<div class="row-fluid">
		<div class="span9">
			<!-- Carousel -->		
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
				),
				'interval' => 6000,
				'infinite' => false,
				'htmlOptions' => array(),
			)); ?-->
			<img src="<?php echo Yii::app()->baseUrl.'/images/banner/6.jpg';?>" />
		</div><!-- /span9 -->
		<div class="span3" >
			<div class="login-signup-flipper">
				<?php $this->widget('ZLogInSignUpFlipper');?>
			</div><!-- login-signup-flipper -->
		</div><!-- /span3 -->
	</div><!-- /row-fluid -->
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
		$this->widget('ext.coursethumbnail.CourseThumbnail', array(
								'course'=>$course,
								'css'=>'coursethumbnail'
		));
		echo CHtml::closeTag('li');
	}
	echo CHtml::closeTag('ul');
}
?>
</div><!-- /container -->
