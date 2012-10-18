<?php
$this->breadcrumbs = array(
	Yii::t('site', 'Courses') => array('index'),
	$model->name,
);
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl.'/js/bootstrap.min.js'
);
?>
<div id="course-header">
	<div class="container">
		<div class="row">
		<div class="course-header-wrapper span12">
			<div class="row">
				<div id="course-intro-video" class="span6">
					<div class="videoWrapper">
						<?php $this->widget('IntroVideoPlayer', array('course'=>$model)); ?>
					</div><!-- /video-wrapper -->
				</div><!-- end course-intro-video -->
				<div id="course-header-description" class="span6"> 
					<div class="row">
						<div id="course-header-name">
							<h1><?php echo CHtml::encode($model->name);?></h1>
							<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->courseInstructorsShortString);?></h3>
						</div><!-- end course-header-name -->		
					</div><!-- end row -->
					<div class="row">
						<div id="course-description">
							<?php echo CHtml::encode($model->short_description); ?>
						</div>
					</div><!-- end row -->
					<div class="row">
						<div id="course-header-button">
							<?php 
							// If a user is a guest, show 'Take Course' and proceed the sign up.
							if (Yii::app()->user->isGuest)
							{
								$this->beginWidget('EBootstrapModal', array(
									'id' => 'signUpModal',
									'show' => false,
									'header' => Yii::t('site', 'To take this course, please log in.'),
									'footer' => array(
										EBootstrap::ibutton(
											Yii::t('site', 'Cancel'),
											'#',
											'',
											'large',
											false,
											'',
											false,
											array('data-dismiss' => 'modal')
										),
									),
								)); 
								$this->widget('ZLogInSignUpFlipper', array(
									'courseId' => $model->id,
									'returnUrl' => $this->createUrl('course/inclass', array('id' => $model->id)),
								));
	
								$this->endWidget(); // end Modal widget
		
								// Take course button
								$this->widget('EBootstrapModalTrigger', array(
									'element' => 'a',
									'value' => Yii::t('site', 'Take course'),
									'modal' => 'signUpModal',
									'htmlOptions' => array(
										'class' => 'btn btn-primary btn-large course-button',
									),	
								));
							}
							// If a user does not enroll in a class, show 'Take course' to enroll.
							else if (!$model->hasStudent(Yii::app()->user->getId()))
							{
								echo EBootstrap::ibutton(
									Yii::t('site', 'Take course'),
									'index.php?r=course/inclass&id='.$model->id,
									'primary',
									'large',
									false,
									'',
									false,
									array('class' => 'course-button')
								);
							}
							// If a user is already enrolled in a class, show 'Go to course'.
							else
							{
								echo EBootstrap::ibutton(
									Yii::t('site', 'Go to course'),
									'index.php?r=course/inclass&id='.$model->id,
									'success',
									'large',
									false,
									'',
									false,
									array('class' => 'course-button')
								);
							}
						?>
						</div><!-- end course-header-button -->
					</div><!-- end row -->
				</div><!-- end course-header-description -->
			</div><!-- end row -->
		</div><!-- end wrapper -->
		</div><!-- end row -->
	</div><!-- end container -->
</div><!-- end course-header -->


<div id="course-summary">
	<div class="container">
		<h1><?php echo Yii::t('site', 'Course Summary');?></h1>
		<p class="well"><?php echo CHtml::encode($model->long_description); ?></p>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="span12">
			<div class="row">
				<div class="span6">
					<div class="row">
						<div class="span6">
							<div id="course-summary">
								<h1><?php echo Yii::t('site', 'Course Summary');?></h1>
								<p class="well"><?php echo CHtml::encode($model->long_description); ?></p>
							</div><!-- course-summary -->
						</div><!-- /span6 -->
					</div><!-- /row -->
					<div class="row">
						<div class="span6">
							<div id="course-syllabus">
								<h1><?php echo Yii::t('site', 'Course Logistics');?></h1>
								<?php $this->widget('ContentList', 	array(
									'contents'=>$contents,
								));?>
							</div><!-- end course-syllabus -->
						</div><!-- /span6 -->
					</div><!-- /row -->
				</div><!-- /span6 -->
				<div class="span6">
					<div id="course-instructors" class="span6">
						<h1><?php echo Yii::t('site', 'Instructor');?></h1>
						<?php $this->widget('InstructorList', array('instructorList'=>$model->instructors));?>
					</div><!-- end course-instructors -->
				</div><!-- /span6 -->
			</div><!-- /row -->
		</div><!-- /span12 -->
	</div><!-- /row -->
</div><!-- /container -->
