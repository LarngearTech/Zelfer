<?php $this->pageTitle=Yii::app()->name; ?>
<div class="header-section">
	<div class="container">
		<?php if (Yii::app()->user->isGuest): ?>
		<div class="row">
			<div class="span9">
				<img src="<?php echo Yii::app()->baseUrl.'/images/banner/6.jpg';?>" />
			</div><!-- /span9 -->
			<div class="span3">
				<?php $this->widget('ZLogInSignUpFlipper');?>
			</div><!-- /span3 -->
		</div><!-- /row -->
		<?php endif; ?>
	</div><!-- /container -->
</div><!-- /header-section -->
<div class="course-list-section">
	<div class="container">
		<?php foreach ($categories as $category): ?>
			<div class="course-category">
				<h1><?php echo CHtml::encode($category->name); ?></h1>
				<?php // display courses of each category ?>
				<?php echo CHtml::openTag('ul', array('class' => 'thumbnails'));
				foreach ($courses_in_categories[$category->id] as $course)
				{
					echo CHtml::openTag('li', array('class' => 'span4'));
					$this->widget('CourseThumbnail', array(
									'course'=>$course,
					));
					echo CHtml::closeTag('li');
				}
				echo CHtml::closeTag('ul'); ?>
			</div><!-- /course-category -->
		<?php endforeach; ?>
	</div><!-- /container -->
</div><!-- /course-list-section -->
