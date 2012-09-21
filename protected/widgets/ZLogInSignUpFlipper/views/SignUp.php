	<?php $this->widget('ZSignUp'); ?>
	<div id="login" class="form-bottom">
		<span>Already have an account? <a href="#" class="goto-login-btn">login </a> </span>
	</div>
	<script type="text/javascript">
		$("#login a").click(function() {
			$.get("LogIn.php", function(data) {
				$(".login-signup-flipper").flip({
					direction: 'lr',
					color: '#ffffff',
					content: data,
				 });
			 });
		 });
	</script>

