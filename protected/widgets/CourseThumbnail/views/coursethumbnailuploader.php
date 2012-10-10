<div class="course-thumbnail-uploader">
<div class="row">
	<div class="span9">
		<h2>Course's Thumbnail<h2>
	</div>
	<div class="span3">
		<div class="coursethumbnail-container">
			<?php 
			$this->widget('CourseThumbnail', array(
				'course'=>$course,
				'courseUrl'=>'#',
			)); 
			?>
		</div>
	</div>
	<div class="span6">
		<div class="upload-thumbnail-caption-container">
			<div>Max 256 KB JPG, PNG, GIF, JPEG and BMP</div>
		</div>
		<div class="upload-thumbnail-file-container">
			<?php
			$this->widget('EAjaxUpload',
				array(
					'id'=>'thumbnailFile',
					'config'=>array(
						'action'=>Yii::app()->createUrl('course/changeThumbnail', array('courseId'=>$course->id)),
						'allowedExtensions'=>array("jpg", "jpeg", "bmp", "gif", "png"),
						'sizeLimit'=> 256*1024,// maximum file size in bytes
						'onComplete'=>"js:function(id, fileName, responseJSON){
								$('.coursethumbnail-container').html(responseJSON.html); 
							}",
					)
				)
			);
			?>
		</div>
	</div>
</div>
</div>
