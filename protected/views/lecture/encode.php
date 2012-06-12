<?php

// Check the video file health
$inputVideoHealthy= $model->inputVideoHealthy;
$info=$model->inputVideoInfo;
$res=$info[1];

// Generate the annotation snapshot if it does not exist
$snapshot_path="$streamingPath/Snapshot.jpg";
$snapshot_web_path=str_replace($_SERVER['DOCUMENT_ROOT'],'http://'.$_SERVER['SERVER_NAME'],$snapshot_path);

$supported_video_extensions= array('avi', 'flv', 'mov', 'mp4',  'mts', 'wmv');
$video_files=array(); $presentation_files=array();


// Get list of video files and list of presentation files
if($dir=opendir($encodingPath)) {
	while (false !== ($file = readdir($dir))) {
		if(substr($file,0,1)!='.') {
			if ( in_array( strtolower( substr($file, -3) ), $supported_video_extensions ) ) {$video_files[]=$file;}
			if(strtolower(substr($file, -3))=='pdf') {$presentation_files[]=$file;}
		}
	}
}

if(!file_exists($snapshot_path)) {
	sort($video_files); $input_file=end($video_files);
	
	// Generate the snapshot
	system("ffmpeg -i \"$encodingPath/$input_file\" -y -s 960x540 -ss 0.05 \"$snapshot_path\"");
}

$has_encoded_video=(file_exists("$streamingPath/video_complete.txt"))?('y'):('n');
$check_openclassroom=''; $check_classx='';
if($has_encoded_video=='y') {
	if(file_exists("$streamingPath/encodedVideo.mp4")) { $check_openclassroom='checked'; }
	else { $check_classx='checked'; }
}
$has_presentations=(sizeof($presentation_files)>0)?('y'):('n');

?>

<div id="divOuter">
	<div style="position:left:50%;width:720px;">
		<h3 class="MainH2" style="font-family:Arial;">Encoding for <?php echo $model->name ?></h3>

		<!-- Internal variables -->
		<input type='hidden' id='has_encoded_video' name='has_encoded_video' value="<?php echo $has_encoded_video ?>"/>
		<input type='hidden' id='has_presentations' name='has_presentations' value="<?php echo $has_presentations ?>"/>
		<input type='hidden' id='resolution' name='resolution' value="<?php echo $res ?>"/>
		
		<?php $form=$this->beginWidget('CActiveForm', array(
								'id'=>'encode-form',
								'enableAjaxValidation'=>false,
								
		)); ?>
			<?php echo $form->hiddenField($encodeOption, 'encodingPath', array('id'=>'encodingPath', 'value'=>$encodingPath)) ?>
			<?php echo $form->hiddenField($encodeOption, 'streamingPath', array('id'=>'streamingPath', 'value'=>$streamingPath)) ?>
			
			<?php
			if($has_encoded_video=='y') { ?>
				<table style='width:700px;'>
					<tr><td style='font-family:Arial;font-weight:bold;font-size:12pt;'>The video for this session has been previously encoded. Do you want to re-encode the video?</td></tr>
					</td></tr>
					<tr><td style='font-family:Arial;'> 
						<?php echo $form->radioButton($encodeOption, 'encode_video', array('id'=>'encode_video_y','value'=>'y', 'onclick'=>'UpdateFormControls()', 'uncheckValue'=>null));?>Yes</td></tr>
					<tr><td style='font-family:Arial;'> 
						<?php echo $form->radioButton($encodeOption, 'encode_video', array('id'=>'encode_video_n','value'=>'n', 'onclick'=>'UpdateFormControls()', 'uncheckValue'=>null));?>No</td></tr>

				</table>
			<?php } else {?>
				<?php echo $form->hiddenField($encodeOption, 'encode_video', array('value'=>'y')) ?>
			<?php } ?>		
			<div id="video_options_div" style="display:block;">
			<?php
			if ($res=='1920x1080') {
			?>
				<table style='width:700px;'>
					<tr><td style='font-family:Arial;font-weight:bold;font-size:12pt;'>Output video format:</td></tr>
					<tr><td style='font-family:Arial;'><?php echo $form->radioButton($encodeOption, 'format', array('id'=>'format_openclassroom', 'onclick'=>'UpdateFormControls()', 'value'=>'openclassroom', 'uncheckValue'=>null, $check_openclassroom)) ?>Standard: Plays back as a 960x540 video with no pan/zoom features</td></tr>
					<tr><td style='font-family:Arial;'><?php echo $form->radioButton($encodeOption, 'format', array('id'=>'format_classx', 'onclick'=>'UpdateFormControls()', 'value'=>'classx', 'uncheckValue'=>null, $check_classx)) ?>Interactive: HD with pan/zoom features and automatic lecturer tracking</td></tr>				
				</table>
			<?php
			} else { ?>
				<?php echo $form->hiddenField($encodeOption, 'format', array('value'=>'openclassroom')) ?>
			<?php } ?>
			<div id='annotation_div' style='width:750px;height:500px;display:block;'>
				<p style="font-family:Arial;font-weight:bold;font-size:12pt;">Please draw rectangles around any boards or slide projections in the scene:</p>
				<object data="data:application/x-silverlight-2," type="application/x-silverlight-2" width="730" height="450">
					<param name="source" value="<?php echo Yii::app()->baseUrl.'/protected/scripts/SceneAnnotationTool.xap'; ?>"/>
					<param name="InitParams" value="<?php echo "snapshotPath=$snapshot_web_path"; ?>" />
					<param name="onError" value="onSilverlightError" />
					<param name="background" value="white" />
					<param name="minRuntimeVersion" value="3.0.40818.0" />
					<param name="autoUpgrade" value="true" />
					<a href="http://go.microsoft.com/fwlink/?LinkID=149156&v=3.0.40818.0" style="text-decoration:none">
							<img src="http://go.microsoft.com/fwlink/?LinkId=108181" alt="Get Microsoft Silverlight" style="border-style:none"/>
					</a>
				</object>
			</div><!-- annotation_div -->
			<?php echo $form->hiddenField($encodeOption, 'scene_annotation_data', array('id'=>'scene_annotation_data', 'value'=>'')) ?>
			</div><!-- video_options_div -->

			<?php
			if(sizeof($presentation_files)>0) {					
			?>
				<br/>
				<table style='width:700px;'>
					<tr><td style='font-family:Arial;font-weight:bold;font-size:12pt;'>There are one or more PDF files for this session. Would you like to synchronize them with the video?</td></tr>
					<tr><td style='font-family:Arial;'><?php echo $form->radioButton($encodeOption, 'sync_slides', array('id'=>'sync_slides_y', 'value'=>'y', 'onclick'=>'UpdateFormControls()', 'uncheckValue'=>null))?>Yes</td></tr>
					<tr><td style='font-family:Arial;'><?php echo $form->radioButton($encodeOption, 'sync_slides', array('id'=>'sync_slides_n', 'value'=>'n', 'onclick'=>'UpdateFormControls()', 'uncheckValue'=>null))?>No</td></tr>
				</table>
			<?php } else { ?>
				<?php echo $form->hiddenField($encodeOption, 'sync_slides', array('value'=>'n')); ?>
			<?php } ?>


		<h4 style='font-family:Arial;'>Start Encoding</h4>
		<p id='encodability_message' style='font-family:Arial;'></p>
		<?php echo CHtml::submitButton('Start encoding', array('id'=>'submit_button', 'style'=>'margin-left:300px;margin-bottom:50px;width:150px;',)) ?>
		<?php $this->endWidget(); ?>
	</div> <!-- <div style="position:left:50%;width:720px;"> -->
			
	<div style="height:50px;">&nbsp;</div>
</div> <!-- divOuter -->

<script type="text/javascript">


	function UpdateFormControls() {
		has_encoded_video=document.getElementById('has_encoded_video').value=='y';
		if(has_encoded_video) {
			video_encode_selected=(document.getElementById('encode_video_y').checked);
		}
		else {
			video_encode_selected=true;
		}
				
		has_presentations=document.getElementById('has_presentations').value=='y';
		if(has_presentations) {
			slide_sync_selected=document.getElementById('sync_slides_y').checked;
		}
		else {
			slide_sync_selected=false;
		}
		is_hd=(document.getElementById('resolution').value=='1920x1080');
		if(is_hd) {
			is_format_selected=(document.getElementById('format_openclassroom').checked || document.getElementById('format_classx').checked);
		}
		else {
			is_format_selected=true;
		}

		// Visibility of video options div
		if(video_encode_selected) {
			document.getElementById('video_options_div').style.display='block';
		}
		else {
			document.getElementById('video_options_div').style.display='none';
		}

		// Visibility of scene annotator div
		if(is_hd && document.getElementById('format_classx').checked==true) {
			document.getElementById('annotation_div').style.display='block';
		}
		else {
			document.getElementById('annotation_div').style.display='none';
		}

		// Completion Status Message and Visibility of Start Button
		if(!video_encode_selected && !slide_sync_selected) {
			document.getElementById('encodability_message').innerHTML="You cannot start an encoding now because you have not selected any encoding tasks.";
			document.getElementById('submit_button').style.display='none';
			return;
		}
		if(!video_encode_selected && slide_sync_selected) {
			document.getElementById('encodability_message').innerHTML="You can start the encoding. You have chosen to synchronize slides without re-encoding the video.";
			document.getElementById('submit_button').style.display='block';
			return;
		}
		if(!is_format_selected) {
			document.getElementById('encodability_message').innerHTML="You cannot start an encoding now because you have not selected a video output format above.";
			document.getElementById('submit_button').style.display='none';
			return;
		}
		if(is_hd) {
			if(document.getElementById('format_classx').checked && document.getElementById('scene_annotation_data').value.length==0) {
				document.getElementById('encodability_message').innerHTML="You cannot start an encoding now because you have not marked any important scene regions above.";
				document.getElementById('submit_button').style.display='none';
				return;
			}
		}
		document.getElementById('encodability_message').innerHTML="You can start the encoding.";
		document.getElementById('submit_button').style.display='block';
				
	}
	function UpdateAnnotationString(data_string) {
		document.getElementById('scene_annotation_data').value=data_string;
		UpdateFormControls();
	}

	function SubmitEncodeForm() {
		document.encode-form.submit();
	}

	// Initialize Form
	if(document.getElementById('has_presentations').value=='y') {
		document.getElementById('sync_slides_y').checked=true;
	}
	UpdateFormControls();
</script>






