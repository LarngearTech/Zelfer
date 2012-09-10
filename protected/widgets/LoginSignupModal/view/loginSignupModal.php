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
	echo $form->errorSummary($userModel); ?>
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

