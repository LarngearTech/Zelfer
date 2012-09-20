<h1><?php echo Yii::t('site', 'Login');?></h1>

<p><?php echo Yii::t('site', 'Please fill out the following form with your login credentials');?>:</p>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <p class="note"><?php echo Yii::t('site', 'Fields with');?> <span class="required">*</span> <?php echo Yii::t('site', 'are required.');?></p>

    <div class="input-row">
        <?php echo $form->labelEx($loginFormModel,'email'); ?>
        <?php echo $form->textField($loginFormModel,'email'); ?>
        <?php echo $form->error($loginFormModel,'email'); ?>
    </div>

    <div class="input-row">
        <?php echo $form->labelEx($loginFormModel,'password'); ?>
        <?php echo $form->passwordField($loginFormModel,'password'); ?>
        <?php echo $form->error($loginFormModel,'password'); ?>
        <p class="hint">
            Hint: You may login with <tt>demo@zelfer.com/demo</tt> or <tt>admin@zelfer.com/admin</tt>.
        </p>
    </div>
    <div class="input-row rememberMe">
        <?php echo $form->checkBox($loginFormModel,'rememberMe'); ?>
        <?php echo $form->label($loginFormModel,'rememberMe'); ?>
        <?php echo $form->error($loginFormModel,'rememberMe'); ?>
    </div>

    <div class="input-row buttons">
        <?php echo CHtml::submitButton(Yii::t('site', 'Login')); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- /form -->
