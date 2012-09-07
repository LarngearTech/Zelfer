<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- bootstrap CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />

	<!-- customized CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="top-bar"> 
	<?php
		// Query all registered courses to display on menu
		if (!Yii::app()->user->isGuest)
		{
			$registeredCourses = array();
			$userModel = User::model()->findByPk(Yii::app()->user->id);
			foreach ($userModel->registeredCourses as $registeredCourse)
			{
				$course = array();
				$course['label'] = $registeredCourse['name'];
				$course['url'] = array('/course/inclass&id='.$registeredCourse['id']);
				$registeredCourses[] = $course;
			}
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
					'label' => Yii::t('site', 'Create Course'),
					'url' => array('/course/create'),
				),
				array(
					'label' => Yii::t('site', 'My Courses'),
					'url' => '#',
					'visible' => !Yii::app()->user->isGuest,
					'dropdown' => true,
					'items' => $registeredCourses,
				),
				array(
					'label' => Yii::t('site', 'Login'), 
					'url' => array('/site/login'),
					'visible' => Yii::app()->user->isGuest,
				),
				array(
					'label' => Yii::t('site', 'Logout').' ('.Yii::app()->user->fullname.')', 
					'url' => array('/site/logout'),
					'visible' => !Yii::app()->user->isGuest,
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
