<?php
$this->breadcrumbs=array(
	'User Subgroups',
);

$this->menu=array(
	array('label'=>'Create UserSubgroup', 'url'=>array('create')),
	array('label'=>'Manage UserSubgroup', 'url'=>array('admin')),
);
?>

<h1>User Subgroups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
