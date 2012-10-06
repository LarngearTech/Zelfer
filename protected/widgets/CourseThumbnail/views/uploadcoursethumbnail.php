<div class="uploadcoursethumbnail">
<div class="row">
	<div class="span3">
		<?php 
		$this->widget('CourseThumbnail', array(
			'course'=>$course,
			'courseUrl'=>'#',
		)); 
		?>
	</div>
	<div class="span6">
		<form class="form">
			<div class="upload-thumbnail-caption-container">
		 		<h3>Upload course's thumbnail</h3>
				<div>Max 256 KB JPG, PNG, GIF, JPEG and BMP</div>
			</div>
			<div class="upload-thumbnail-file-container">
				<?php
				$this->widget('XUpload', array(
					'url'=>Yii::app()->createUrl('course/uploadThumbnail'),
					'multiple'=>true,
					'model'=>$course,
					'attribute'=>'thumbnail-file',
				));
				?>
			</div>
		</div>
	</div>
</div>
</div>
