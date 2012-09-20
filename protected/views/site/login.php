<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
	Yii::t('site', 'Login'),
);
?>
<div class="container">
  <?php $this->widget('ZLogIn');?>
</div><!-- /container -->
