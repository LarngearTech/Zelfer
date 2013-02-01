<?php	
	$this->widget('FileUploader',
		array('config'=>array(
			'id'=>'material-file-uploader-'.$contentId,
			'placeholder'=>'Browse File',
			'btnLabel'=>'Choose File',
			'url'=>Yii::app()->createUrl('course/uploadSupplementaryMaterial',
				array('contentId'=>$contentId)),
			//'deleteUrl'=>Yii::app()->createUrl('course/deleteContentVideo',
			//	array('contentId'=>$contentId)),
			'onDone'=>"js:editContent(".$contentId.
				",'".$contentPrefix."')",
			)
		)
	);
?>
<div>
	<div>Supplementary material file size must be less than 10MB</div>
</div>