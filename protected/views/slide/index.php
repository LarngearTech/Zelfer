<?php
$this->breadcrumbs=array(
	'Slides',
);

$this->menu=array(
	array('label'=>'Create Slide', 'url'=>array('create')),
	array('label'=>'Manage Slide', 'url'=>array('admin')),
);
?>

<h1>Slides</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
