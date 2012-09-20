	<h2 class="side-lined">
		Sign up with your email					:
	</h2>
	<div class="fields">
		<div class="form-item fullName">
			<input id="fullName" name="fullName" type="text" class="text-input	" placeholder="" autocomplete="off"><span class="placeholder">Full Name</span><input type="hidden" id="fullName_insideText" value="Full Name" autocomplete="off">						<span class="error-text"> </span>
		</div>
		<div class="form-item email">
			<input id="email" name="email" type="text" class="text-input	" rel="isEmailValid" placeholder="" autocomplete="off"><span class="placeholder">E-mail</span><input type="hidden" id="email_insideText" value="E-mail" autocomplete="off">						<span class="error-text"> </span>
		</div>
		<div class="form-item password">
			<input id="password" name="password" type="password" class="text-input	" placeholder="" autocomplete="off"><span class="placeholder">Password</span><input type="hidden" id="password_insideText" value="Password" autocomplete="off">						<span class="error-text"> </span>
		</div>
		<div class="form-errors"></div>
	</div>
	<div class="form-bottom">
		<a class="signup-btn u-btn green medium" href="#">sign up </a> 
	</div>
	<div id="login" class="form-bottom">
		<span>Already have an account? <a href="#" class="goto-login-btn">login </a> </span>
	</div>
	<script type="text/javascript">
		$("#login a").click(function() {
			$.get("login-view.html", function(data) {
				$(".auth-form").flip({
					direction: 'lr',
					color: '#ffffff',
					content: data,
				 });
			 });
		 });
	</script>
