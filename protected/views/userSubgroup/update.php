<div class="container">
	<h1><?php echo Yii::t('site', 'Update').' '.Yii::t('site', 'User Subgroup').' '.$model->name; ?></h1>

	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div><!-- /.container -->