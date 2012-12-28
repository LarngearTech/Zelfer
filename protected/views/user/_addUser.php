<table>
	<thead>
		<tr>
			<th><?php echo Yii::t('site', 'id');?></th>
			<th><?php echo Yii::t('site', 'fullname');?></th>
			<th><?php echo Yii::t('site', 'email');?></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user): ?>
		<tr>
			<td><?php echo $user->id;?></td>
			<td><?php echo $user->fullname;?></td>
			<td><?php echo $user->email;?></td>
			<td>
				<?php
					echo CHtml::link(CHtml::image('images/update.png', 'update'),
						Yii::app()->createUrl('user/update', array('id'=>$user->id))
					);
					echo CHtml::link(CHtml::image('images/delete.png', 'delete'),
						Yii::app()->createUrl('user/delete', array('id'=>$user->id))
					);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	<tr>
		<td></td>
		<td><?php echo CHtml::textField('fullname','',array('id'=>$txtFullName)); ?></td>
		<td><?php echo CHtml::textField('email','',array('id'=>$txtEmail)); ?></td>
		<td>
			<i class="icon-plus" onclick="<?php echo $addHandler; ?>"/>
		</td>
	</tr>
</table>
