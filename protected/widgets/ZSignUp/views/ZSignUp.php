<h1><?php echo Yii::t('site', 'Sign Up');?></h1>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'signup-form',
	'enableAjaxValidation' => false,
)); ?>

	<?php echo $form->errorSummary($userModel); ?>

	<div class="input-row">
		<?php echo $form->textField($userModel,'fullname',array('size' => 60, 'maxlength' => 128, 'placeholder' => Yii::t('site', 'Full Name'))); ?>
		<?php echo $form->error($userModel,'fullname'); ?>
	</div>

	<div class="input-row">
		<?php echo $form->textField($userModel,'email',array('size'=>60,'maxlength'=>128, 'placeholder' => Yii::t('site', 'Email'))); ?>
		<?php echo $form->error($userModel,'email'); ?>
	</div>

	<div class="input-row">
		<?php echo $form->passwordField($userModel,'password',array('size'=>60,'maxlength'=>128, 'placeholder' => Yii::t('site', 'Password'))); ?>
		<?php echo $form->error($userModel,'password'); ?>
	</div>

	<div class="input-row">
		<?php echo $form->passwordField($userModel,'repeat_password',array('size'=>60,'maxlength'=>128, 'placeholder' => Yii::t('site', 'Repeat password'))); ?>
		<?php echo $form->error($userModel,'repeat_password'); ?>
	</div>

	<?php if ($courseId != null): ?>
	<div class="input-row">
		<?php echo CHtml::hiddenField('courseId', $courseId); ?>
	</div>
	<?php endif; ?>
	<?php if ($returnUrl != null): ?>
	<div class="input-row">
		<?php echo CHtml::hiddenField('returnUrl', $returnUrl); ?>
	</div>
	<?php endif; ?>

	<div class="input-row buttons">
		<?php echo CHtml::submitButton($userModel->isNewRecord ? Yii::t('site', 'Sign Up') : Yii::t('site', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

