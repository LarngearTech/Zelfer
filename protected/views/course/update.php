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
?>

<div class=container>
<h1><?php echo Yii::t('site', 'Edit Course');?> <?php echo $model->name; ?></h1>
<div id="edit-course-menu" class="row">
	<div class="span12">
		<div class="btn-toolbar well">
			<div class="btn-group">
				<?php echo CHtml::link(
					Yii::t('site', 'Delete Course'), 
					array(
						'course/delete',
						'courseId' => $model->id,
					),
					array(
						'class' => 'btn btn-danger',
						'confirm' => 'Do you really want to delete this course, this cannot be undone',
					)
				);?>
			</div><!-- end btn-group -->
			<div class="btn-group">
				<?php 
				// Not yet publish course
				if ($model->status == 0){
					echo CHtml::link(
						Yii::t('site', 'Publish Course'), 
						array(
							'course/publish',
							'courseId' => $model->id,
						),
						array(
							'class' => 'btn btn-success',
							'confirm' => 'Do you really want to publish this course',
						)
					);
				}
				else {
					echo CHtml::link(
						Yii::t('site', 'Unpublish Course'), array(
							'course/unpublish',
							'courseId' => $model->id,
						),
						array(
							'class' => 'btn btn-warning',
							'confirm' => 'Do you really want to unpublish this course',
						)
					);
				}?>
			</div><!-- end btn-group -->
		</div><!-- end btn-toolbar-->
		<div class="tabbable tabs-left">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#course_info" data-toggle="tab">Course Info</a><li>
				<li><a href="#instructor_info" data-toggle="tab">Instructor Info</a><li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="course_info">
					<?php 
					$this->render('_updateCourseInfo',
						array(
							'model'=>$model,
							'categoryList'=>$categoryList,
						)
					);
					?>
				</div>
				<div class="tab-pane" id="instructor_info">
					<?php
					$this->render('_updateInstructorInfo');
					?>
				</div>
			<div>
		</div>	
	</div><!-- end wrapper -->
</div>
</div>
