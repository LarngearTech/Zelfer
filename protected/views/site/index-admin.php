<?php 

$this->pageTitle=Yii::app()->name; 

Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl.'/js/bootstrap.min.js'
);
Yii::app()->clientScript->registerScript(
        'toggle-taking-teaching',
        '$(function(){
		$("#student-btn").on("click", function(event) {
                	$("#student-list").show();
                	$("#teacher-list").hide();
        	});
        	$("#teacher-btn").on("click", function(event) {
                	$("#student-list").hide();
                	$("#teacher-list").show();
        	});
	});
	function addStudent(){
		if ($("#txtStudentFullName").val() == ""
		|| $("#txtStudentEmail").val() == "")
		{
			alert("Not enough information to create new account");
		}
		else
		{
			$.ajax({
				url:"'.Yii::app()->createUrl('user/add').'",
				type:"POST",
				dataType:"html",
				data:{
					fullname:$("#txtStudentFullName").val(),
					email:$("#txtStudentEmail").val(),
					role:"2"
				},
				success:function(html){
					$("#student-list").html(html);
				}
			});
		}
	}
	function addTeacher(){
		if ($("#txtTeacherFullName").val() == ""
		|| $("#txtTeacherEmail").val() == "")
		{
			alert("Not enough information to create new account");
		}
		else
		{
			$.ajax({
				url:"'.Yii::app()->createUrl('user/add').'",
				type:"POST",
				dataType:"html",
				data:{
					fullname:$("#txtTeacherFullName").val(),
					email:$("#txtTeacherEmail").val(),
					role:"1"
				},
				success:function(html){
					$("#teacher-list").html(html);
				}
			});
		}
	}
	'	
	,
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
			<?php $this->renderPartial('/user/_addUser', array(
				'users'=>$user->students,
				'txtFullName'=>'txtStudentFullName',
				'txtEmail'=>'txtStudentEmail',
				'addHandler'=>'addStudent();',
			));?>
		</div>
		<div id="teacher-list">
			<?php $this->renderPartial('/user/_addUser', array(
				'users'=>$user->teachers,
				'txtFullName'=>'txtTeacherFullName',
				'txtEmail'=>'txtTeacherEmail',
				'addHandler'=>'addTeacher();',
			));?>
		</div>
	</div><!-- /container -->
</div><!-- /course-list-section -->
