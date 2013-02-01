<div>
	<span class="group-prefix"><?php echo $groupPrefix; ?></span>
	<span id="group-name-<?php echo $group->id; ?>" class="group-name"><?php echo $group->name; ?></span>
	<span class="edit-panel">
		<a class="btn group-edit" onclick="js:editGroup(<?php echo $group->id; ?>, '<?php echo $groupPrefix?>')" title="<?php echo Yii::t('site', 'Edit');?>"><i class="icon-pencil"></i></a>
		<a class="btn group-delete" onclick="js:deleteGroup(<?php echo $group->id; ?>)" title="<?php echo Yii::t('site', 'Delete');?>"><i class="icon-trash"></i></a>
	</span>
</div>
