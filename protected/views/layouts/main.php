<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- bootstrap CSS framework -->
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap.css'); ?>
	<!--?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap-responsive.css'); ?-->

	<!-- customized CSS -->
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/main.css') ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="top-bar"> 
	<?php
		// Query all registered courses to display on menu
		$userModel;
		$mycourseUrl="#";
		if (!Yii::app()->user->isGuest)
		{
			$userModel = User::model()->findByPk(Yii::app()->user->id);
			$mycourseUrl = Yii::app()->createUrl('course/myCourse', array('uid'=>$userModel->id));
		}
		
		$this->widget('EBootstrapNavigation', array(
			'fixed' => true,
			'htmlOptions' => array(
				'class' => 'navbar-inverse',
			),
			'items' => array(
				array(
					'label' => Yii::t('site', 'Home'),
					'url' => array('/site/index'),
				),
				array(
					'label' => !Yii::app()->user->isGuest?$userModel->fullname:'Guest',
					'url' => '#',
					'dropdown' => true,
					'items' => array(
							array('label' => Yii::t('site', 'Edit Profile'), 'url' => '#'),
							array('label' => Yii::t('site', 'Change Password'), 'url' => '#'),
							array('label' => Yii::t('site', 'My Activities'), 'url' => '#'),
							array('label' => Yii::t('site', 'Logout'), 'url' => array('/site/logout')),
						),
					'visible' => !Yii::app()->user->isGuest,
				),
				array(
					'label' => Yii::t('site', 'Create Course'),
					'url' => array('/course/create'),
					'visible' => !Yii::app()->user->isGuest,
				),
				array(
					'label' => Yii::t('site', 'My Courses'),
					'url' => $mycourseUrl,
					'visible' => !Yii::app()->user->isGuest,
				),
				array(
					'label' => Yii::t('site', 'Login'), 
					'url' => array('/site/login'),
					'visible' => Yii::app()->user->isGuest,
				),
			),
		));
	?>
</div><!-- end top-bar -->
<div id="page">

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- end page -->
<!-- footer -->
<div id="footer">
	<?php echo Yii::t('site', 'Copyright'); ?> &copy; <?php echo date('Y'); ?> Zelfer.com<br/>
	<?php echo Yii::t('site', 'All Rights Reserved.'); ?><br/>
</div><!-- end footer -->

</body>
</html>
