<?php
$this->breadcrumbs = array(
	Yii::t('site', 'Users') => array('index'),
	Yii::t('site', 'Create'),
);

$this->menu = array(
	array('label' => Yii::t('site', 'List User'), 'url' => array('index')),
	array('label' => Yii::t('site', 'Manage User'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('site', 'Create User')?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
