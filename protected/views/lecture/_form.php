<div class="form">

<?php
	$blueArrowPath =Yii::app()->baseUrl.'/protected/uploads/blue_arrow.png';
	$yellowMarkPath=Yii::app()->baseUrl.'/protected/uploads/yellow_mark.png';
	$greenCheckPath=Yii::app()->baseUrl.'/protected/uploads/green_check.png';
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lecture-form',
	'enableAjaxValidation'=>false,
)); ?>

	<!-- Step 1: Session title and description -->
	<div>
		<div>
			<?php
				if ($model->step1Complete)
				{
					$image_src=$greenCheckPath;
					$lower_cell_content="This lecture has a date and description (" .
					CHtml::link('Click here to edit',
						    array('lecture/editInfo',
							'lectureId'=>$model->id,
							'chapterId'=>$chapterId,
							'courseId' =>$courseId,
							'returnAction'=>$returnAction)) .
					") You may continue with the next steps.";
				}
				else
				{
					$image_src=$blueArrowPath;
					$lower_cell_content="Please enter a date and description " .
					CHtml::link('here',
						    array('lecture/editInfo',
							'lectureId'=>$model->id,
							'chapterId'=>$chapterId,
							'courseId' =>$courseId,
							'returnAction'=>$returnAction));
				}
			?>
			<img src='<?php echo $image_src ?>' width=20 height=20/>
			<?php echo 'Step 1: Title and Description' ?>
			<?php echo $lower_cell_content ?>
		</div>
	</div>
	
	<!-- Step 2:File Management -->
	<div>
	<?php
		if(!$model->inputVideoHealthy)
		{
			if($model->step1Complete)
			{ ?>
				<img src='<?php echo $blueArrowPath ?>' width=30 height=20/>
			<?php }
			else
			{ ?>
				&nbsp;
			<?php }					
		}
		else
		{ ?>
			<img src='<?php echo $greenCheckPath ?>' width=20 height=20/>
		<?php } ?>
		<?php echo 'Step 2: Upload/Delete Files' ?>
		<?php echo 
			CHtml::link('Click here  to upload, view, or delete files for this lecture',
			  array('lecture/uploadVideo',
				'lectureId'=>$model->id));
		?>



	</div>

	<!-- Step 3: Video Health Check -->
	<div>
		<?php 
			if(!$model->inputVideoHealthy)
			{ ?>
				&nbsp;
			<?php } 
			elseif($model->hasWarning) 
			{ ?>
				<img src="<?php echo $yellowMarkPath ?>" width=20 height=20/>
			<?php } 
			else 
			{ ?>
				<img src="<?php echo $greenCheckPath ?>" width=20 height=20/>
			<?php } ?>
			<?php echo 'Step 3: Video File Check' ?> 
			<?php
			if($model->inputVideoHealthy) {
				if(!$model->hasWarning)
				{ ?>
					Passed.
				<?php } 
				else 
				{ ?>
					Passed with warnings: Please try to resolve the following issues in order to guarantee successful encoding.<?php echo $model->warningMessage ?>
				<?php 
				}
			}
			else 
			{?>
				Failed. Reason: <?php echo $model->videoCheckError; ?>
			<?php
			}
			?>						
	</div>

	<!-- Step 4: Encoding Options and Encoding -->
	<div>
		<?php
		if($model->isPreviouslyEncoded) 
		{ ?>
			<img src='<?php echo $greenCheckPath ?>' width=20 height=20/>
		<?php } 
		elseif($model->isEncoding) 
		{ ?>
			<img src='<?php echo $yellowMarkPath ?>' width=20 height=20/>
		<?php } 
		else 
		{ 
			if($model->step1Complete && $model->inputVideoHealthy) 
			{?>
				<img src='<?php echo $blueArrowPath ?>' width=20 height=20/>
			<?php } 
			else 
			{ ?>
				&nbsp;
			<?php }
		} ?>						
		<?php	echo 'Step 4: Enter Encoding Options and Start Encoding' ?>
	
		<?php
			if($model->canEncode)
			{
				if($model->isPreviouslyEncoded) 
				{ 
					echo 'This session has been encoded previously, but you can encode it again if you want to use different files or encoding settings. '; 
				}
				if($model->isEncoding)
				{ 
					echo 'Warning: This session currently has an ongoing encoding. If you issue a new encoding, it will override the previous one. '; 
				}
				echo CHtml::link('Click here to go to the encoding page',
						 array('lecture/encode',
						       'id'=>$model->id));
			}
			else {
			?>
				You cannot start encoding until the previous three steps are passed.
			<?php
			}
			?>						
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
