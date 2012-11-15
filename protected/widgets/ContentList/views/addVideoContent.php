<?php
	$this->widget('FileUploader',
		array('config'=>array(
			'id'=>'video-file-uploader-'.$contentId,
			'placeholder'=>'Video file should have size less than 2GB',
			'btnLabel'=>'Choose Video File',
			'url'=>Yii::app()->createUrl('course/uploadContentVideo',
				array('contentId'=>$contentId)),
			'deleteUrl'=>Yii::app()->createUrl('course/deleteContentVideo',
				array('contentId'=>$contentId)),
		))
	);
?>
