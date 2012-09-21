	<?php $this->widget('ZLogIn'); ?>
	<div id="signup" class="form-bottom">
        <span>Don't you have an account? <a href="#" class="goto-signup-btn">signup now </a> </span>
    </div>
    <script type="text/javascript">
        $("#signup a").click(function() {
            $.get("SignUp.php", function(data) {
                $(".login-signup-flipper").flip({
                    direction: 'rl',
                    color: '#ffffff',
                    content: data,
                 });
             });
         });
    </script>
