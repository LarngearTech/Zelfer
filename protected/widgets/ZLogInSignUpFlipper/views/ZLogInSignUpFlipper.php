<div class="login-signup-flipper">
	<div class="flip-fore">
		<?php $this->widget('ZLogIn', array(
			'courseId' => $courseId,
			'returnUrl' => $returnUrl,
		));?>
		<div class="form-bottom">
			<span><?php echo Yii::t('site', "Don't you have an account?");?> <a href="#" class="goto-signup-btn"><?php echo Yii::t('site', 'signup now');?> </a> </span>
		</div>

	</div><!-- /fore -->

	<div class="flip-back">
		<?php $this->widget('ZSignUp', array(
			'courseId' => $courseId,
			'returnUrl' => $returnUrl,
		));?>
		<div class="form-bottom">
			<span><?php echo Yii::t('site', 'Already have an account?');?> <a href="#" class="goto-login-btn"><?php echo Yii::t('site', 'login');?> </a> </span>
		</div>

	</div><!-- /back -->

</div><!-- login-signup-flipper -->
