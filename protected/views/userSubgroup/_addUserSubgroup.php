<table>
	<thead>
		<tr>
			<th><?php echo Yii::t('site', 'id');?></th>
			<th><?php echo Yii::t('site', 'name');?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php //$userSubgroups = $userGroupModel->subgroups; 
		foreach ($userSubgroups as $subgroup): ?>
		<tr>
			<td><?php echo $subgroup->id;?></td>
			<td><?php echo $subgroup->name;?></td>
			<td>
				<?php
					echo CHtml::link(CHtml::image('images/update.png', 'update'),
						Yii::app()->createUrl('userGroup/update', array('id'=>$subgroup->id))
					);
					echo CHtml::link(CHtml::image('images/delete.png', 'delete'),
						Yii::app()->createUrl('userGroup/delete', array('id'=>$subgroup->id))
					);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td></td>
		<td><?php echo CHtml::textField('UserSubgroup[name]','',array('id'=>'txtUserSubgroupName')); ?></td>
		<td>
			<i class="icon-plus" id="addSubgroup"></i>
		</td>
	</tr>
</table>