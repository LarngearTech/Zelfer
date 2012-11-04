<?php 
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap.min.js');
?>

<div class=container>
	<div class="row">
		<div class="span9">
			<h1><?php echo Yii::t('site', 'Edit Course');?> <?php echo $model->name; ?></h1>
		</div><!-- /span8 -->
		<div class="span3">
			<div class="btn-toolbar">
				<div class="btn-group">
					<?php echo CHtml::link(
						Yii::t('site', 'Delete'), 
						array(
							'course/delete',
							'courseId'=>$model->id,
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
							Yii::t('site', 'Publish'), 
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
							Yii::t('site', 'Unpublish'), array(
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

		</div><!-- /span4 -->

	</div><!-- /row -->
<div id="edit-course-menu" class="row">
	<div class="span12">
		<div class="tabbable tabs-top">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#course_info" data-toggle="tab">Course Info</a><li>
				<li><a href="#instructor_info" data-toggle="tab">Instructor Info</a><li>
				<li><a href="#course_content" data-toggle="tab">Course Content</a><li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="course_info">
					<?php 
					$this->renderPartial('_updateCourseInfo',
						array(
							'model'=>$model,
							'categoryList'=>$categoryList,
						)
					);
					?>
				</div>
				<div class="tab-pane" id="instructor_info">
					<?php
					$this->renderPartial('_updateInstructorInfo',
						array(
							'model'=>$model,
						)
					);
					?>
				</div>
				<div class="tab-pane" id="course_content">
					<?php
					$this->renderPartial('_updateCourseContent',
						array(
							'model'=>$model,
						)
					);
					?>
				</div>
			<div><!-- /tab-content -->
		</div><!-- /tabbale -->	
	</div><!-- /span12 -->
</div><!-- /row -->
