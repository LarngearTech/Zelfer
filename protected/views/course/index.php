<?php
$this->breadcrumbs = array(
	Yii::t('site', 'Courses'),
);

$this->menu=array(
	array('label' => 'Create Course', 'url' => array('create')),
	array('label' => 'Manage Course', 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('site', 'Courses');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>
