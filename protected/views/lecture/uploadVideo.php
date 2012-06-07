
<div style="width:720px;z-index:2;">

<h3 >Files for <?php echo $model->name ?></h3>
				
	<!-- Instructions -->
	<h3 style="font-family:Arial;">Instructions</h3>
	<ol style='font-family:Arial;'>
		<li>Upload your video and presentation PDF files using the download widgets below.</li>
		<li>After all uploads are complete, click on the refresh link next to "File Summary" below to see the updated list of files and let the system check your video files for integrity.</li>
		<li>When all the files are okay and the video check is passed, click "Done" at the bottom of this page.</li>
	</ol>

	<!-- File upload -->
	<h3 style="font-family:Arial;">File Upload</h3>
	<iframe src="<?php echo $uploaderUrl ?>" width="720" height="200" scroll="yes" style="margin-left:15px;border:1px solid #AAAAAA">
		<p style="font-family:Arial;">This feature cannot be displayed because your browser does not support IFrames.</p>
	</iframe>

	<!-- File summary -->
	<table style="padding-top:15px;"><tr>
		<td colspan="2"><h3 style="font-family:Arial;">File Summary [<a href="javascript:RefreshFileSummary()">Click here to refresh</a>]</h3></td>
		</tr></table>
		<iframe id='summary_iframe' src="<?php echo "$fileSummaryUrl" ?>?encodingPath=<?php echo $encodingPath ?>&streamingPath=<?php echo $streamingPath ?>" width="720" height="500" scroll="yes" style="margin-left:15px;margin-bottom:10px;border:1px solid #AAAAAA">
			<p style="font-family:Arial;">This feature cannot be displayed because your browser does not support IFrames.</p>
		</iframe>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lecture-form',
	'enableAjaxValidation'=>false,
)); ?>
	<input type='hidden' name='uploadDone' value="true"/>	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Done',
					array('style'=>'width:120px;margin-left:300px;margin-bottom:50px;')); ?>
	</div>
<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
	function RefreshFileSummary() {
		document.getElementById('summary_iframe').src=document.getElementById('summary_iframe').src;
	}
</script>
