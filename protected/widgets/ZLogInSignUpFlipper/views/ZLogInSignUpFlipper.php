<div class="login-signup-flipper">
	<div class="flip-fore">
		<?php $this->widget('ZLogIn');?>
		<div class="form-bottom">
			<span>Don't you have an account? <a href="#" class="goto-signup-btn">signup now </a> </span>
		</div>

	</div><!-- /fore -->

	<div class="flip-back">
		<?php $this->widget('ZSignUp');?>
		<div class="form-bottom">
			<span>Already have an account? <a href="#" class="goto-login-btn">login </a> </span>
		</div>

	</div><!-- /back -->

</div><!-- login-signup-flipper -->
