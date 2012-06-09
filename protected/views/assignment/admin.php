<?php
$this->breadcrumbs=array(
	'Assignments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Assignment', 'url'=>array('index')),
	array('label'=>'Create Assignment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('assignment-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Assignments</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'assignment-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'course_id',
		'type',
		'release_date',
		'full_credit_expiry_date',
		/*
		'reduced_credit_expiry_date',
		'reduced_credit_percentage',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
