<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('course_id')); ?>:</b>
	<?php echo CHtml::encode($data->course_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('release_date')); ?>:</b>
	<?php echo CHtml::encode($data->release_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('full_credit_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->full_credit_expiry_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reduced_credit_expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->reduced_credit_expiry_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('reduced_credit_percentage')); ?>:</b>
	<?php echo CHtml::encode($data->reduced_credit_percentage); ?>
	<br />

	*/ ?>

</div>