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
			<div id="chapter<?php echo $chapIdx;?>-collapse" class="accordion-body collpase chapter">
				<div class="accordion-inner">
					<ul>
					<?php foreach ($chapter->lectures as $lecture): ?>
						<li class="lecture">
							<div class="lecture-name">
								<?php echo CHtml::encode($lecture->name);?>
							</div><!-- /lecture-name -->
						</li>	
					<?php endforeach; ?>
					</ul>
				</div>
			</div><!-- /chapter<?php echo $chapIdx;?> -->
		</div><!-- /accordion-group -->
	<?php endforeach; ?>
	</div><!-- /accordion -->
