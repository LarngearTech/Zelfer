<?php	
	$this->widget('FileUploader',
		array('config'=>array(
			'id'=>'video-file-uploader-'.$contentId,
			'placeholder'=>'Browse File',
			'btnLabel'=>'Choose Video File',
			'url'=>Yii::app()->createUrl('course/uploadSupplementaryMaterial',
				array('contentId'=>$contentId)),
			'deleteUrl'=>Yii::app()->createUrl('course/deleteContentVideo',
				array('contentId'=>$contentId)),
		))
	);
?>
<div>
	<div>Supplementary material file size must be less than 10MB</div>
	<div>
		<input class="btn" 
			type="button" 
			onclick="js:editContent(<?php echo $contentId;?>, '<?php echo $contentPrefix; ?>')" 
			value="Back">
	</div>
</div>