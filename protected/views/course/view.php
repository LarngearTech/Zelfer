<?php
$this->breadcrumbs = array(
	Yii::t('site', 'Courses') => array('index'),
	$model->name,
);
?>

<h1><?php echo CHtml::encode($model->name); ?></h1>
<h3><?php echo Yii::t('site', 'By').' '.CHtml::encode($model->instructors[0]->fullname); 
	$numIns = count($model->instructors);
	if ($numIns == 2)
	{
		echo ' '.Yii::t('site', 'and').' '.CHtml::encode($model->instructors[1]->fullname);
	}
	else if ($numIns > 2)
	{
		echo ' '.Yii::t('site', 'and {numIns} others.', array(
			'{numIns}' => $numIns
		));
	}?>
</h3>
<br/>
<p class="well"><?php echo CHtml::encode($model->short_description); ?></p>
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
		'header' => Yii::t('site', 'To take this course, please sign up.'),
		'footer' => array(
			EBootstrap::ibutton(
                		Yii::t('site', 'Sign Up'),
                		'#',
                		'primary',
                		'large',
                		false,
                		'',
                		false,
                		array('id' => 'signup-btn')
        		),
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
	// Modal content
	$userModel = new User; 
	$form = $this->beginWidget('EBootstrapActiveForm', array(
		'id' => 'user-form',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
		'action' => 'index.php?r=user/create',
	));
	?>
	<?php echo $form->errorSummary($userModel); ?>
	<div>
		<?php echo $form->labelEx($userModel,'fullname'); ?>
		<?php echo $form->textField($userModel,'fullname',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($userModel,'fullname'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($userModel,'email'); ?>
		<?php echo $form->textField($userModel,'email',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($userModel,'email'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($userModel,'password'); ?>
		<?php echo $form->passwordField($userModel,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($userModel,'password'); ?>
	</div>

	<div>
		<?php echo $form->labelEx($userModel,'repeat_password'); ?>
		<?php echo $form->passwordField($userModel,'repeat_password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($userModel,'repeat_password'); ?>
	</div>
	<?php echo CHtml::hiddenField('returnUrl', $model->getInClassUrl());?>
				
	<?php 
	$this->endWidget(); // end ActiveForm widget

	$this->endWidget(); // end Modal widget

	// Take course button
	$this->widget('EBootstrapModalTrigger', array(
		'element' => 'a',
		'value' => 'Take course',
		'modal' => 'signUpModal',
		'htmlOptions' => array(
			'class' => 'btn btn-primary',
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
		array()
	);
}
// If a user is already enrolled in a class, show 'Go to course'.
else
{
	echo EBootstrap::ibutton(
		Yii::t('site', 'Go to course'),
		'index.php?r=course/inclass&id='.$model->id,
		'primary',
		'large',
		false,
		'',
		false,
		array()
	);
}
?>
<br/>
<br/>

<?php $this->widget('application.extensions.videojs.EVideoJS', array(
	'options' => array(
		// Unique identifier, is autogenerated by default, useful for jQuery integrations.
		'id' => false,
		// Video and poster width in pixels
		'width' => 640,
		// Video and poster height in pixels
		'height' => 360,
		// Poster image absolute URL
		'poster' => false,
		// Absolute URL of the video in MP4 format
		//'video_mp4' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.mp4',
		'video_mp4' => $model->introUrl,
		// Absolute URL of the video in OGV format
		//'video_ogv' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF',
		// Absolute URL of the video in WebM format
		//'video_webm' => 'http://www.html5rocks.com/en/tutorials/video/basics/Chrome_ImF.webm',
		// Use Flash fallback player ?
		//'flash_fallback' => true,
		'flash_fallback' => false,
		// Address of custom Flash player to use as fallback
		//'flash_player' => 'swf/ClassXPlayer_v2.swf',
		'flash_player' => false,
		// Show controls ?
		'controls' => true,
		// Preload video content ?
		'preload' => false,
		// Autostart the playback ?
		'autoplay' => false,
		// Show VideoJS support link ?
		'support' => false,
		// Show video download links ?
		'download' => false,
	),
));
?>
<br/>
<div id="course-summary">
	<h2><?php echo Yii::t('site', 'Course Summary');?></h2>
	<p class="well"><?php echo CHtml::encode($model->long_description); ?></p>
</div>
<div id="course-instructors">
	<h2><?php echo Yii::t('site', 'Instructor');?></h2>
	<ul>
	<?php
		foreach ($model->courseInstructors as $instructorRecord)
		{
			echo '
			<li><h3>'.$instructorRecord['fullname'].'</h3>'.
				'<h4>'.$instructorRecord['instructor_career'].'</h4>'.
				'<br/>'.$instructorRecord['instructor_description'].'</br>
			</li>';
		}
	?>
	</ul>
</div>
<div id="course-syllabus">
	<h2><?php echo Yii::t('site', 'Course Logistics');?></h2>
	<?php
	// create contents for the lecture tab 
	$this->widget('ext.slidetoggle.ESlidetoggle', array(
		'itemSelector' => 'ul.collapsible',
		'collapsed' => 'ul.collapsible',
		'titleSelector' => 'ul.collapsible .caption',
	));
	$lecturesTabContent = '';
	$chapIdx = 0;
	foreach ($chapters as $chapter)
	{
		$chapIdx++;
		$lecturesTabContent .= '<ul class="collapsible"><span class="caption" style="margin-left:-1.5em;">'.Yii::t('site', 'Chapter').' '.$chapIdx.' '.CHtml::encode($chapter->name).'</span>';

		// create a lecture list
		$lectIdx = 0;
		foreach ($chapter->lectures as $lecture)
		{
			$lecturesTabContent .= '<li>'.CHtml::encode($lecture->name).'</li>';
		}
		$lecturesTabContent .= '</ul>';
	}
	echo $lecturesTabContent;
?>
</div>
