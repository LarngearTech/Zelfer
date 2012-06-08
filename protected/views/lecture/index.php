<?php
$this->breadcrumbs=array(
	'Lectures',
);

$this->menu=array(
	array('label'=>'Create Lecture', 'url'=>array('create')),
	array('label'=>'Manage Lecture', 'url'=>array('admin')),
);
?>

<h1>Lectures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
