		<?php 

$this->pageTitle=Yii::app()->name; 

Yii::app()->clientScript->registerScriptFile(
        Yii::app()->baseUrl.'/js/bootstrap.min.js'
);
Yii::app()->clientScript->registerScript(
        'toggle-taking-teaching',
        '$(function() {
			$("#student-btn").on("click", function(event) {
	                	$("#student-list").show();
	                	$("#teacher-list").hide();
	        	});
	        	$("#teacher-btn").on("click", function(event) {
	                	$("#student-list").hide();
	                	$("#teacher-list").show();
	        	});
			});
			function addUserGroup() 
			{
				if ($("#txtUserGroupName").val() == "")
				{
					alert("Please specify group name.");
				}
				else
				{
					$.ajax({
						url: "'.Yii::app()->createUrl('userGroup/create').'",
						type: "POST",
						dataType: "html",
						data: {
							"UserGroup[name]": $("#txtUserGroupName").val()
						},
						success: function(html) {
							$("#group-list").html(html);
						}
					});
				}
			}
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
			}'	
		, CClientScript::POS_END
);?>
<div class="container">
	<div class="row">
		<div class="stack-wrapper span3">
			<?php $this->widget('MenuList', array(
				'menus' => $menus,
			));?>
		</div>
		<div class="span9">
			<div class="add-user-wrapper">
				<?php $this->renderPartial('/site/admin/_user', array(
					'users' => $users,
					'userGroups' => $userGroups,
				));?>
			</div><!-- /.add-user-wrapper -->
		</div>
	</div><!-- /.row -->
</div><!-- /.container -->
