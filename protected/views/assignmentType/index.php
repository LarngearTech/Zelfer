<?php
$this->breadcrumbs=array(
	'Assignment Types',
);

$this->menu=array(
	array('label'=>'Create AssignmentType', 'url'=>array('create')),
	array('label'=>'Manage AssignmentType', 'url'=>array('admin')),
);
?>

<h1>Assignment Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
