<!DOCTYPE html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<meta name="description" content="Online Course Platform">
	<meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>">
	<meta property="og:description" content="Online Course Platform">
	<meta property="og:url" content="">
	<meta name="viewport" content="width=device-width">
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap.min.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/bootstrap-responsive.min.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/main.css'); ?>
	<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/main-responsive.css'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/modernizr-2.6.2-respond-1.1.0.min.js');?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/html5placeholder.jquery.js',CClientScript::POS_END); ?>


</head>

<body>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->
<div class="top-bar"> 
	<?php
		// Query all registered courses to display on menu
		$userModel;
		$mycourseUrl = "#";
		$updateProfileUrl = "#";
		$exploreCourseUrl = Yii::app()->createUrl('course/explore');
		if (!Yii::app()->user->isGuest)
		{
			$userModel = User::model()->findByPk(Yii::app()->user->id);
			$mycourseUrl = Yii::app()->createUrl('course/myCourse', array('uid' => $userModel->id));
			$updateProfileUrl = Yii::app()->createUrl('user/update', array('id' => $userModel->id));
		}
		
		$this->widget('EBootstrapNavigation', array(
			'fixed' => false,
			'responsive' => true,
			'htmlOptions' => array(
				'class' => 'navbar-inverse',
			),
			'items' => array(
				array(
					'label' => Yii::t('site', 'OMC!'),
					'url' => array('/site/index'),
					'template' => '{brand}',
				),
				array(
					'label' => Yii::t('site', 'Log In'),
					'url' => array('/site/login'),
					'visible' => Yii::app()->user->isGuest,
				),
				array(
					'label' => !Yii::app()->user->isGuest?$userModel->fullname:'Guest',
					'url' => '#',
					'dropdown' => true,
					'items' => array(
							array('label' => Yii::t('site', 'Edit Profile'), 'url' => $updateProfileUrl),
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
					'label' => Yii::t('site', 'Explore Courses'),
					'url' => $exploreCourseUrl,
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
