<?php
$this->breadcrumbs=array(
	'User Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserGroup', 'url'=>array('index')),
	array('label'=>'Manage UserGroup', 'url'=>array('admin')),
);
?>

<h1>Create UserGroup</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>