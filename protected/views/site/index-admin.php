<?php 

$this->pageTitle=Yii::app()->name; 

Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl.'/js/bootstrap.min.js'
);
Yii::app()->clientScript->registerScript(
        'toggle-taking-teaching',
        '$("#student-btn").on("click", function(event) {
                $("#student-list").show();
                $("#teacher-list").hide();
        });
        $("#teacher-btn").on("click", function(event) {
                $("#student-list").hide();
                $("#teacher-list").show();
        });',
        CClientScript::POS_END
);

?>
<div class="mycourse-wrapper">
	<div class="container">
		<div id="usergroup-btn" class="btn-group" data-toggle="buttons-radio">
			<button type="button" id="student-btn" class="btn active"><?php echo Yii::t('site', 'Student');?></button>
			<button type="button" id="teacher-btn" class="btn"><?php echo Yii::t('site', 'Teacher');?></button>
		</div>
		<div id="student-list">
		<?php
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'student-grid',
				'dataProvider'=>$dataProvider->student,
				'columns'=>array(
					'id',
					'fullname',
					'email',
					'password',
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update} {delete}',
						'updateButtonUrl'=>'Yii::app()->createUrl("user/update", array("id"=>$data->id))',
						'deleteButtonUrl'=>'Yii::app()->createUrl("user/delete", array("id"=>$data->id))',
					),
				),
			));
		?>
		</div>
		<div id="teacher-list">
		<?php
			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'teacher-grid',
				'dataProvider'=>$dataProvider->teacher,
				'columns'=>array(
					'id',
					'fullname',
					'email',
					'password',
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update} {delete}',
						'updateButtonUrl'=>'Yii::app()->createUrl("user/update", array("id"=>$data->id))',
						'deleteButtonUrl'=>'Yii::app()->createUrl("user/delete", array("id"=>$data->id))',
					),
				),
			));
		?>
		</div>
	</div><!-- /container -->
</div><!-- /course-list-section -->
