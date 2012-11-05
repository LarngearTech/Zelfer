<div class="course-thumbnail-uploader clearfix">
	<label><?php echo Yii::t('site', 'Course\'s Thumbnail');?></label>
	<div class="coursethumbnail-container">
		<?php 
		$this->widget('CourseThumbnail', array(
			'course'=>$course,
			'courseUrl'=>'#',
		)); 
		?>
	</div>
	<div class="clearfix"></div>
	<div class="upload-thumbnail-caption-container">
		<?php echo Yii::t('site', 'Max');?> 256 KB JPG, PNG, GIF, JPEG and BMP
	</div>
	<div class="upload-thumbnail-file-container">
		<?php
		$this->widget('EAjaxUpload', array(
				'id' => 'thumbnailFile',
				'config' => array(
					'action' => Yii::app()->createUrl('course/changeThumbnail', array('courseId' => $course->id)),
					'allowedExtensions' => array("jpg", "jpeg", "bmp", "gif", "png"),
					'sizeLimit' => 256*1024,// maximum file size in bytes
					'onComplete' => "js:function(id, fileName, responseJSON){
							$('.coursethumbnail-container').html(responseJSON.html); 
						}",
				)
			)
		);
		?>
	</div>
</div>
