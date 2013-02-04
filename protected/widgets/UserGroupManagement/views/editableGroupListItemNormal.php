<div>
	<span class="group-prefix"><?php echo $groupPrefix; ?></span>
	<span id="group-name-<?php echo $group->id; ?>" class="group-name"><?php echo $group->name; ?></span>
	<span class="edit-panel">
		<a class="btn group-edit" title="<?php echo Yii::t('site', 'Edit');?>" data-groupid="<?php echo $group->id;?>" data-group-prefix="<?php echo $groupPrefix;?>">
			<i class="icon-pencil"></i>
		</a>
		<a class="btn group-delete" title="<?php echo Yii::t('site', 'Delete');?>" data-groupid="<?php echo $group->id;?>" >
			<i class="icon-trash"></i>
		</a>
	</span>
</div>
