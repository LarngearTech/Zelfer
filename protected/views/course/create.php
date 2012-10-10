<?php
$this->breadcrumbs=array(
	'Courses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);
?>
<div class="container">
<div class="span12">
<h1><?php echo Yii::t('site', 'Create Course');?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
					'categoryList'=>$categoryList,)); ?>
</div><!-- /span12 -->
</div><!-- /container -->
