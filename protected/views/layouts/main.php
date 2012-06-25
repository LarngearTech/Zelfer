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
	<div id="mainmenu" class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="<?php echo CHtml::normalizeUrl(array('/site/index'));?>"><?php echo CHtml::encode(Yii::app()->name); ?></a>
				<?php $this->widget('zii.widgets.CMenu',array(
					'items' => array(
						array('label' => Yii::t('site', 'Home'), 'url' => array('/site/index')),
						/*array('label' => Yii::t('site', 'About'), 'url' => array('/site/page', 'view'=>'about')),
						array('label' => Yii::t('site', 'Contact'), 'url' => array('/site/contact')),*/
						array('label' => Yii::t('site', 'Create Course'), 'url' => array('/course/create')), 
						array('label' => Yii::t('site', 'My Courses'), 'url' => array('/user/mycourses'), 'visible' => !Yii::app()->user->isGuest),
						array('label' => Yii::t('site', 'Login'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
						array('label' => Yii::t('site', 'Logout').' ('.Yii::app()->user->fullname.')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
					),
					'htmlOptions' => array(
						'class' => 'nav',
					),
				)); ?>
			</div>
		</div>
	</div><!-- end mainmenu -->
</div><!-- end top-bar -->
<div id="page" class="container">
	<!-- breadcrumbs -->
	<div id="breadcrumbs" class="breadcrumbs">
		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('EBootstrapBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			)); ?>
		<?php endif?>
	</div><!-- end breadcrumbs -->

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
