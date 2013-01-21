<?php $this->pageTitle=Yii::app()->name; ?>
<?php if (Yii::app()->user->isGuest): ?>
<div class="header-section">
	<div class="container">
		<div class="row">
			<div class="header-wrapper span12">
				<div class="row">
					<div class="span8">
						<!--img src="<?php echo Yii::app()->baseUrl.'/images/banner/6.jpg';?>" /-->
					</div><!-- /span9 -->
					<div class="span4">
						<div class="login-signup-wrapper rounded-corners">
							<?php 
								/*$this->widget('ZLogInSignUpFlipper', array(
									'returnUrl' => Yii::app()->request->requestUri,
								));*/
								$this->widget('ZLogIn', array(
									'returnUrl'=>Yii::app()->request->requestUri,
								));
							?>
						</div><!-- /login-signup-wrapper -->
					</div><!-- /span3 -->
				</div><!-- /row -->
			</div><!-- /header-wrapper -->
		</div><!-- /row -->
	</div><!-- /container -->
</div><!-- /header-section -->
<?php endif; ?>
<?php $this->renderPartial('//course/_courseList', array(
		'categories' => $categories,
		'courses_in_categories' => $courses_in_categories,
));?>