	<div class="accordion" id="chapter-accordion">
	<?php $chapIdx = 0; ?>
	<?php foreach ($chapters as $chapter): ?>
		<?php $chapIdx++; ?>
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#chapter-accordion" href="#chapter<?php echo $chapIdx;?>-collapse">
					<?php echo $chapIdx.'.'.CHtml::encode($chapter->name);?>
				</a>
			</div><!-- /accordion-heading -->
			<div id="chapter<?php echo $chapIdx;?>-collapse" class="accordion-body collapse <?php if ($chapIdx==1) echo 'in';?> chapter">
				<div class="accordion-inner-wrapper">
				<div class="accordion-inner">
					<ul>
					<?php foreach ($chapter->lectures as $lecture): ?>
						<li class="lecture">
							<a href="#"><?php echo CHtml::encode($lecture->name);?><em><img src="<?php echo Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.widgets.ZLectureStack.assets.images'));?>/play.png" class="playbutton" id='<?php echo Yii::app()->baseUrl.'/course/'.$lecture->id.'/';?>'/></em></a>
						</li>	
					<?php endforeach; ?>
					</ul>
				</div><!-- /accordion-inner -->
				</div><!-- /accordion-inner-wrapper -->
			</div><!-- /chapter<?php echo $chapIdx;?> -->
		</div><!-- /accordion-group -->
	<?php endforeach; ?>
	</div><!-- /accordion -->
