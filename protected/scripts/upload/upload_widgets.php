<?php

$IMG_IAF_CROSS_PATH = '../../uploads/iaf_cross.png';
$IMG_IAF_CHECK_PATH = '../../uploads/iaf_check.png';

// Get subject information
$encodingPath      =	$_GET["encodingPath"];
$streamingPath     = 	$_GET["streamingPath"];

$uploader_url="iaf_widget.php?encodingPath=$encodingPath&streamingPath=$streamingPath";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
	<body>
		<p style="font-family:Arial;font-size:8pt;font-weight:bold;margin-left:20px;">You may click the <img vertical-align='text-bottom' src='<?php echo $IMG_IAF_CROSS_PATH ?>'/> next to any active upload to cancel it. You may click the <img src='<?php echo $IMG_IAF_CHECK_PATH ?>'/> next to any completed upload to use that uploader to upload a new file.</p>
		<p style='font-family:Arial;font-size:8pt;font-weight:bold;margin-left:20px;color:red;'>The upload widgets use flash. If you are on a MAC, they may not function properly (may show upload pending forever).</p>
		<table style='margin-left:10px;'>
			<tr>
				<td width='340'><iframe src="<?php echo $uploader_url ?>" style='width:320px;height:100px;border:0px;'></iframe></td>
				<td width='320'><iframe src="<?php echo $uploader_url ?>" style='width:320px;height:100px;border:0px;'></iframe></td>
			</tr>
		</table>
	</body>
</html>



