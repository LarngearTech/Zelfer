<div class="container">
	<h1>Update User Group <?php echo $userGroupModel->name; ?></h1>

	<?php echo $this->renderPartial('_form', array('model'=>$userGroupModel)); ?>

	<h1>User Subgroup</h1>
	<div id="subgroup-list">
		<?php echo $this->renderPartial('/userSubgroup/_addUserSubgroup', array(
			'userSubgroups' => $userGroupModel->subgroups,
		)); ?>
	</div><!-- /#subgroup-list -->
</div><!-- /.container -->
<?php $cs = Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerScript('addSubgroup','
		$(function() {
			$("#subgroup-list").on("click", "#addSubgroup", function(event) {
				if ($("#txtUserSubgroupName").val() == "")
				{
					alert("Please specify subgroup name.");
				}
				else
				{
					$.ajax({
						url: "'.Yii::app()->createUrl('userSubgroup/create').'",
						type: "POST",
						dataType: "html",
						data: {
							"UserSubgroup[name]": $("#txtUserSubgroupName").val(),
							"UserSubgroup[group_id]": '.$userGroupModel->id.'
						},
						success: function(html) {
							 $("#subgroup-list").html(html);
						}
					});
				}
			});
		})
		' , CClientScript::POS_END);
?>
