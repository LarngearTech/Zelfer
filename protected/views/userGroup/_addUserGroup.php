<table>
	<thead>
		<tr>
			<th><?php echo Yii::t('site', 'id');?></th>
			<th><?php echo Yii::t('site', 'name');?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($userGroups as $group): ?>
		<tr>
			<td><?php echo $group->id;?></td>
			<td><?php echo $group->name;?></td>
			<td>
				<?php
					echo CHtml::link(CHtml::image('images/update.png', 'update'),
						Yii::app()->createUrl('userGroup/update', array('id'=>$group->id))
					);
					echo CHtml::link(CHtml::image('images/delete.png', 'delete'),
						Yii::app()->createUrl('userGroup/delete', array('id'=>$group->id))
					);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td></td>
		<td><?php echo CHtml::textField('UserGroup[name]','',array('id'=>$txtUserGroupName)); ?></td>
		<td>
			<i class="icon-plus" id="add-user-group" />
		</td>
	</tr>
</table>
