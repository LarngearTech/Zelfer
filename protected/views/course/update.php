<?php
$this->breadcrumbs = array(
	Yii::t('site', 'Courses') => array('index'),
	$model->name => array('view','id' => $model->id),
	Yii::t('site', 'Edit'),
);

$this->menu = array(
	array('label' => 'List Course', 'url' => array('index')),
	array('label' => 'Create Course', 'url' => array('create')),
	array('label' => 'View Course', 'url' => array('view', 'id' => $model->id)),
	array('label' => 'Manage Course', 'url' => array('admin')),
);
?>
<?php 
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap.min.js');
	Yii::app()->clientScript->registerScript('dropdown-toggle',
		'$(".dropdown-toggle").dropdown();');
?>

<div class=container>
<h1><?php echo Yii::t('site', 'Edit Course');?> <?php echo $model->name; ?></h1>
<div id="edit-course-menu" class="row">
	<div class="span12">
		<div class="btn-toolbar">
			<div class="btn-group">
				<?php echo CHtml::link(
					Yii::t('site', 'Create Lecture'), array(
						'lecture/create',
						'lectureId' => '', 
						'chapterId' => '1',
						'courseId' => $model->id,
					),
					array(
						'class' => 'btn',
					)
				);?>
			</div><!-- end btn-group -->
			<div class="btn-group">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					<?php echo Yii::t('site', 'More');?>
					<span class="caret"></span>		
				</a>
				<ul class="dropdown-menu">
					<?php echo CHtml::link(Yii::t('site', 'Edit Instructors'), array('editInstructor',
						'courseId' => $model->id,
					));?>
				</ul>
			</div><!-- end btn-group -->
		</div><!-- end btn-toolbar -->
	</div><!-- end wrapper -->
</div>
</div>
