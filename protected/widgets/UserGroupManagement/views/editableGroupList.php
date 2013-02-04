<?php 
$cs = Yii::app()->clientScript;
$cs->registerScript(
	'toggle-edit-panel',
	'$(document).on({
		mouseenter: function() {
			$("> .edit-panel", this).show();
		},
		mouseleave: function() {
			if (!$(this).hasClass("group-editing"))
			{
				$("> .edit-panel", this).hide();
			}
		}
	}, ".group-list li div");',
	CClientScript::POS_END
);
$cs->registerScript(
	'update-group-item-ui',
	'function updateContentItemUi(groupId, html){
		$("#group_"+groupId).html(html).removeClass("group-editing");
		makeSortable();
	}',
	CClientScript::POS_END
);
$cs->registerScript(
	'edit-group-handle',
	'function editContent(groupId, groupPrefix){
		$("#group_"+groupId).addClass("group-editing");
		$.ajax({
			url:"'.Yii::app()->createUrl('userGroup/editContent').'",
			data:{
				groupId:groupId,
				groupPrefix:groupPrefix,
			},
			type:"POST",
			dataType:"html",
			success:function(html){
				$("#group_"+groupId).html(html);
				makeSortable();
			}
		});
	}',
	CClientScript::POS_END
	
);
$cs->registerScript(
	'commit-group-handle',
	'function commitContent(groupId, groupPrefix){
		$.ajax({
			url:"'.Yii::app()->createUrl('userGroup/commitContent').'",
			data:{
				groupId:groupId,
				groupName:$("#txt-group-name-"+groupId).val(),
				groupPrefix:groupPrefix,
			},
			type:"POST",
			dataType:"html",
			success:function(html){
				updateContentItemUi(groupId, html);
			}
		});
	}',
	CClientScript::POS_END 
);
$cs->registerScript(
	'cancel-edit-group-handle',
	'function cancelEditContent(groupId, groupPrefix){
		$.ajax({
			url:"'.Yii::app()->createUrl('userGroup/cancelEditContent').'",
			data:{
				groupId:groupId,
				groupPrefix:groupPrefix,
			},
			type:"POST",
			dataType:"html",
			success:function(html){
				$("#group_"+groupId).html(html).removeClass("group-editing");
				makeSortable();
			}
		});
	}',
	CClientScript::POS_END
);
$cs->registerScript(
	'delete-group-handle',
	'$("#group-list").on("click", ".btn.group-delete", function() {
		var groupId = $(this).data("groupid");
		$.ajax({
			url: "'.Yii::app()->createUrl("userGroup/delete").'&id=" + groupId + "&ajax=delete-group",
			data: {
				groupId: groupId, 
			},                      
			type: "POST",
			dataType: "html",
			success:function(html) {
				$(".editable-group-list-container").html(html);
				makeSortable();
			}
		});
	});',
	CClientScript::POS_END
);
?>

<ul class='group-list'>
<?php
	$groupId = 0;
	$subgroupId = 0;
	$groupPrefix;
	$class;

	foreach ($groups as $group)
	{
		if ($group->isGroup())
		{
			$class = 'editable-group';
			$groupId++;
			$subgroupId = 0;
			$groupPrefix = Yii::t('site', 'Group')." ".$groupId.": ";
		}
		else if($group->isSubgroup())
		{
			$class = 'editable-subgroup';
			$subgroupId++;
			$groupPrefix = Yii::t('site', 'Subgroup')." ".$subgroupId.": ";
		}

		echo '<li id="group_'.$group->id.'" class="'.$class.'">';
		$this->widget('EditableGroupListItem', array(
			'groupPrefix' => $groupPrefix,
			'group' => $group,
		));
		echo '</li>';
	}
?>
</ul>
