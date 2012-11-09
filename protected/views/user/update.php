<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<div class="container">
	<h1><?php echo Yii::t('site', 'User Profile'); ?></h1>
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div><!-- /container -->
