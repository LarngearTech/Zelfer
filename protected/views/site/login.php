<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	Yii::t('site', 'Login'),
);
?>
<div class="container">
<h1><?php echo Yii::t('site', 'Login');?></h1>

<p><?php echo Yii::t('site', 'Please fill out the following form with your login credentials');?>:</p>

<div class = "form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note"><?php echo Yii::t('site', 'Fields with');?> <span class="required">*</span> <?php echo Yii::t('site', 'are required.');?></p>

	<div class="input-row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="input-row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
		<p class="hint">
			Hint: You may login with <tt>demo@zelfer.com/demo</tt> or <tt>admin@zelfer.com/admin</tt>.
		</p>
	</div>

	<div class="input-row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="input-row buttons">
		<?php echo CHtml::submitButton(Yii::t('site', 'Login')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- /form -->
</div><!-- /container -->
