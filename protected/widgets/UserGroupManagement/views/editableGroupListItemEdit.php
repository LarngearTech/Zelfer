<div>
	<span class="group-prefix"><?php echo $groupPrefix; ?></span>
	<span id="group-name-<?php echo $group->id; ?>" class="group-name">
		<input id="txt-group-name-<?php echo $group->id; ?>" type="text" value="<?php echo $group->name; ?>"/>
	</span>
	<div class="edit-panel">
		<a class="btn commit-group" title="<?php echo Yii::t('site', 'Save');?>" data-groupid="<?php echo $group->id; ?>" data-group-prefix="<?php echo $groupPrefix; ?>">
			<i class="icon-ok"></i>
		</a>
		<a class="btn cancel-edit-group" title="<?php echo Yii::t('site', 'Cancel');?>" data-groupid="<?php echo $group->id; ?>" data-group-prefix="<?php echo $groupPrefix; ?>">
			<i class="icon-repeat"></i>
		</a>
		<a class="btn delete-group" title="<?php echo Yii::t('site', 'Delete');?>" data-groupid="<?php echo $group->id; ?>">
			<i class="icon-trash"></i>
		</a>
	</div>
	<?php if ($group->isSubgroup()): ?>
	<div id="edit-group-body-<?php echo $group->id; ?>" class="edit-group-body">
		<?php $this->render('userList', array(
			'group' => $group,
			'users' => $users,
		));?>
	</div>
	<?php endif; ?>
</div>
