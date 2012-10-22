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
		<div class="well form">
			<?php
			$this->widget('CourseThumbnailUploader', array(
				'course'=>$model,
				'courseUrl'=>'#',
			));
			?>
		</div>
	</div><!-- /span6 -->
</div><!-- /row -->
<div class="row">
	<div class="span12">
		<div class="well form">
			<?php
			$this->widget('IntroVideoUploader', array(
				'course'=>$model,
			));
			?>
		</div>
	</div>
</div>
