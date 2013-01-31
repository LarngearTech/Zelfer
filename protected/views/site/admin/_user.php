<div id="user-manage-tabs">
	<div class="tabbable tabs-top">
		<?php $this->widget('EBootstrapTabNavigation', array(
			'items' => array(
				array('label' => Yii::t('site', 'User'), 'url' => '#user', 'active' => true),
				array('label' => Yii::t('site', 'Group'), 'url' => '#group'),
				array('label' => Yii::t('site', 'Import'), 'url' => '#import'),
			),
		));
		$this->beginWidget('EBootstrapTabContentWrapper');
			$this->beginWidget('EBootstrapTabContent', array(
				'active' => true,
				'id' => 'user',
			));?>
				<!-- user mangement -->
				<div id="usergroup-btn" class="btn-group" data-toggle="buttons-radio">
					<button type="button" id="student-btn" class="btn active"><?php echo Yii::t('site', 'Student');?></button>
					<button type="button" id="teacher-btn" class="btn"><?php echo Yii::t('site', 'Teacher');?></button>
				</div>
				<div id="student-list">
					<?php $this->renderPartial('/user/_addUser', array(
						'users'=>$users->students,
						'txtFullName'=>'txtStudentFullName',
						'txtEmail'=>'txtStudentEmail',
						'addHandler'=>'addStudent();',
					));?>
				</div>
				<div id="teacher-list">
					<?php $this->renderPartial('/user/_addUser', array(
						'users'=>$users->teachers,
						'txtFullName'=>'txtTeacherFullName',
						'txtEmail'=>'txtTeacherEmail',
						'addHandler'=>'addTeacher();',
					));?>
				</div>
			<?php $this->endWidget(); // EBootstrapTabContent-user ?>

			<?php $this->beginWidget('EBootstrapTabContent', array(
				'id' => 'group',
				)); ?>
				<!-- group management -->
				<div id="group-list">
					<?php $this->renderPartial('/userGroup/_addUserGroup', array(
						'userGroups'=>$userGroups,
						'txtUserGroupName'=>'txtUserGroupName',
						'addHandler'=>'addUserGroup();',
					));?>
				</div>
			<?php $this->endWidget(); // EBootstrapTabContent-group ?>

			<?php $this->beginWidget('EBootstrapTabContent', array(
				'id' => 'import',
				)); ?>
				<!-- import function -->
				The import feature is coming soon...
			<?php $this->endWidget(); // EBootstrapTabContent-import ?>
		<?php $this->endWidget(); // /EBootstrapTabContentWrapper ?>
	</div><!-- /.tabbable -->
</div><!-- /#user-manage-tabs -->
<?php 
	$cs = Yii::app()->getClientScript();
	$cs->registerScript('addUserGroup', '
		$(function() {
			$("#group-list").on("click", "#add-user-group", function() {
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
			});
		});'
		, CClientScript::POS_END);
	$cs->registerScript('deleteUserGroup','
		$(function() {
			$("#group-list").on("click", ".delete-user-group", function(event) {
				var userGroupId = $(this).data("user-group-id");
				$.ajax({
					url: "'.Yii::app()->createUrl("userGroup/delete").'&id=" + userGroupId + "&ajax=usergroup-grid",
					type: "POST",
					dataType: "html",
					success: function(html) {
						$("#group-list").html(html);
					}
				});
			});
		})' 
	, CClientScript::POS_END);
?>