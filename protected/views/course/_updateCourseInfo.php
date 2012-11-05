<div class="row">
	<div class="span6">
		<div class="well form">
			<?php
			$this->renderPartial('_form', array(
				'model'=>$model,
				'categoryList'=>$categoryList,
			));
?>
		</div>
	</div><!-- /span6 -->
	<div class="span6">
		<div class="row">
			<div class="span6">
				<div class="well form">
					<?php
						$this->widget('CourseThumbnailUploader', array(
						'course'=>$model,
						'courseUrl'=>'#',
					));
					?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span6">
				<div class="well form">
						<?php
					$this->widget('IntroVideoUploader', array(
						'course'=>$model,
						));
					?>
				</div>
			</div>
		</div>
	</div><!-- /span6 -->
</div><!-- /row -->
