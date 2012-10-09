<div class="uploadcoursethumbnail">
<div class="row">
	<div class="span3">
		<div class="course-thumbnail-container">
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
	 		<h3>Upload course's thumbnail</h3>
			<div>Max 256 KB JPG, PNG, GIF, JPEG and BMP</div>
		</div>
		<div class="upload-thumbnail-file-container">
			<?php
			$this->widget('EAjaxUpload',
				array(
					'id'=>'uploadFile',
					'config'=>array(
						'action'=>Yii::app()->createUrl('course/changeThumbnail', array('courseId'=>$course->id)),
						'allowedExtensions'=>array("jpg", "jpeg", "bmp", "gif", "png"),
						'sizeLimit'=> 256*1024,// maximum file size in bytes
						'onComplete'=>"js:function(id, fileName, responseJSON){
								$('.course-thumbnail-container').html(responseJSON.html); 
							}",
					)
				)
			);
			?>
		</div>
	</div>
</div>
</div>
