<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- bootstrap CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="mainmenu" class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="#"><?php echo CHtml::encode(Yii::app()->name); ?></a>
				<?php $this->widget('zii.widgets.CMenu',array(
					'items' => array(
						array('label' => Yii::t('site', 'Home'), 'url' => array('/site/index')),
						array('label' => Yii::t('site', 'About'), 'url' => array('/site/page', 'view'=>'about')),
						array('label' => Yii::t('site', 'Contact'), 'url' => array('/site/contact')),
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
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<?php echo Yii::t('site', 'Copyright'); ?> &copy; <?php echo date('Y'); ?> Zelfer.com<br/>
		<?php echo Yii::t('site', 'All Rights Reserved.'); ?><br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
