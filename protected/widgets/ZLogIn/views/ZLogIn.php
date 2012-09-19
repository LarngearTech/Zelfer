	<h2 class="side-lined">
		<?php echo Yii::t('site', 'Login with your email'); ?> :
	</h2>
	<div class="fields">
		<div class="form-item email">
			<input id="email" name="email" type="text" class="text-input	" placeholder="" autocomplete="off"><span class="placeholder">E-mail</span><input type="hidden" id="email_insideText" value="E-mail" autocomplete="off">						<span class="error-text"> </span>
		</div>
		<div class="form-item password">
			<input id="password" name="password" type="password" class="text-input	" placeholder="" autocomplete="off"><span class="placeholder">Password</span><input type="hidden" id="password_insideText" value="Password" autocomplete="off">					 <span class="error-text"> </span>
		</div>
		<div class="form-errors"></div>
	</div>
	<div class="form-bottom">
		<a class="login-btn u-btn green medium" href="">login </a> <a href="http://www.udemy.com/user/forgot-password" class="forgot">Forgot Password? </a>
	</div>
	<div id="signup" class="form-bottom">
		<span>Don't you have an account? <a href="#" class="goto-signup-btn">signup now </a> </span>
	</div>
	<script type="text/javascript">
		$("#signup a").click(function() {
			$.get("signup-view.html", function(data) {
				$(".auth-form").flip({
					direction: 'rl',
					color: '#ffffff',
					content: data,
				 });
			 });
		 });
	</script>
