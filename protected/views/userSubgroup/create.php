<?php
$this->breadcrumbs=array(
	'User Subgroups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserSubgroup', 'url'=>array('index')),
	array('label'=>'Manage UserSubgroup', 'url'=>array('admin')),
);
?>

<h1>Create UserSubgroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>