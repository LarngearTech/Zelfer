<table>
	<thead>
		<tr>
			<th><?php echo Yii::t('site', 'id');?></th>
			<th><?php echo Yii::t('site', 'name');?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php // show all subgroups that are belong to this group
		foreach ($userSubgroups as $subgroup): ?>
		<tr>
			<td><?php echo $subgroup->id;?></td>
			<td><?php echo $subgroup->name;?></td>
			<td>
				<?php // update button
					echo CHtml::link(CHtml::image('images/update.png', 'update'),
						Yii::app()->createUrl('userSubgroup/update', array('id'=>$subgroup->id)),
						array('data-subgroupid' => $subgroup->id)
					);
					// delete button
					echo CHtml::link(
						CHtml::image('images/delete.png', 'delete'),
						array(
							'class' => 'delete-subgroup', 
							'data-subgroup-id' => $subgroup->id
						)
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