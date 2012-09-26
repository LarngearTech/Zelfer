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
					<?php $this->widget('application.extensions.videojs.EVideoJS', array(
						'options' => array(
							// Unique identifier, is autogenerated by default, useful for jQuery integrations.
							'id' => false,
							// Video and poster width in pixels
							'width' => 460,
							// Video and poster height in pixels
							'height' => 258,
							// Poster image absolute URL
							'poster' => false,
							// Absolute URL of the video in MP4 format
							'video_mp4' => $model->introUrl.".mp4",
							// Absolute URL of the video in OGV format
							//'video_ogv' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.ogv',
							'video_ogv' => $model->introUrl.".ogv",
							// Absolute URL of the video in WebM format
							//'video_webm' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.webm',
							// Use Flash fallback player ?
							'flash_fallback' => true,
							//'flash_fallback' => false,
							// Address of custom Flash player to use as fallback
							//'flash_player' => 'swf/ClassXPlayer_v2.swf',
							//'flash_player' => false,
							'flash_player' => 'http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf',
							// Show controls ?
							'controls' => true,
							// Preload video content ?
							'preload' => true,
							// Autostart the playback ?
							'autoplay' => false,
							// Show VideoJS support link ?
							'support' => false,
							// Show video download links ?
							'download' => false,
						),
					));
					?>
				</div><!-- end course-intro-video -->
				<div id="course-header-description" class="span6"> 
					<div class="row">
						<div id="course-institute-logo">
							<a href=""><img width=100 height=100 src="<?php echo Yii::app()->baseUrl.'/institute/tpa/logo.png'; ?>"/></a>
						</div>
					</div>
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
								echo "<script type='text/javascript'>
									$(document).ready(function() {
										$('#signup-btn').click(function(e) {
											e.preventDefault();
											$('#signUpModal').modal('hide');
											$('form').submit();
										})
									});
								</script>";
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
								$this->widget('ZLogInSignUpFlipper');
	
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
	<div id="course-syllabus" class="span6">
		<h1><?php echo Yii::t('site', 'Course Logistics');?></h1>
		<?php
		$chapIdx = 0;
		$lecturesTabContent = '<div class="accordion" id="chapter-accordion">';
		foreach ($chapters as $chapter)
		{
			$chapIdx++;
			$lecturesTabContent .= '
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#chapter-accordion" href="#chapter'.$chapIdx.'-collapse">
							'.Yii::t('site', 'Chapter').' '.$chapIdx.' '.CHtml::encode($chapter->name).'
						</a>
					</div><!-- heading -->
					<div id="chapter'.$chapIdx.'-collapse" class="accordion-body collapse in">
						<div class="accordion-inner">
							<ul>';
			// create a lecture list
			$lectIdx = 0;
			foreach ($chapter->lectures as $lecture)
			{
				$lecturesTabContent .= '<li>'.CHtml::encode($lecture->name).'</li>';
			}
			$lecturesTabContent .= '</ul>
						</div><!-- inner -->
					</div><!-- body -->
				</div><!-- group -->
			';
		}
		$lecturesTabContent .= '</div><!-- accordion -->'; 
		echo $lecturesTabContent;
	?>
	</div><!-- end course-syllabus -->
	<div id="course-instructors" class="span6">
		<h1><?php echo Yii::t('site', 'Instructor');?></h1>
		<?php
			foreach ($model->courseInstructors as $instructorRecord)
			{
				$instructorModel = User::model();
				$instructorModel->id = $instructorRecord['id'];
				echo '<div class="instructor">
						<div class="instructor-image">'.
							CHtml::image($instructorModel->profileImageUrl, 'Image of '.$instructorRecord['fullname']).'
						</div>
						<div class="instructor-detail">
							<h2>'.$instructorRecord['fullname'].'</h3>
							<h4>'.$instructorRecord['instructor_career'].'</h4>								<p>'.$instructorRecord['instructor_description'].'</p>
						</div>
					</div><!-- end instructor -->';
			}
		?>
	</div><!-- end course-instructors -->
</div>
</div>
