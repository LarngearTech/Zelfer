<?php

// Get subject information
$encodingPath     = $_GET["encodingPath"];
$streamingPath    = $_GET["streamingPath"];

// Call the snapshot generator to make sure all input video files have snapshot images
system("perl ./generate_raw_video_snapshots.pl \"$encodingPath\"");

// Check the video file health
$vht_string=exec("perl ./video_health_check.pl \"$encodingPath\"",$retval);
$input_video_healthy=(substr($vht_string,0,1)=='1');

// Get list of video files and list of presentation files
$supported_video_extensions= array('avi', 'flv', 'mov', 'mp4',  'mts', 'wmv');
$video_files=array(); $presentation_files=array();
$snapshots=array();

if($dir=opendir($encodingPath)) {
	while (false !== ($file = readdir($dir))) {
		if(substr($file,0,1)!='.') {
			if ( in_array( strtolower( substr($file, -3) ), $supported_video_extensions ) ) {
				$video_files[]=$file;
				$snapshots[]=substr($file,0,-3)."jpg";
			}
			if (strtolower(substr($file, -3)) == 'pdf') {
				$presentation_files[]=$file;
			}
		}
	}
}
sort($video_files); sort($presentation_files);

// Create table cells for video file preview
$video_cells=array();
for ($i=0;$i<sizeof($video_files);$i++) {
	$file=$video_files[$i];
	$snapshot=$snapshots[$i];
	$video_cells[]="<table style='width:150px;height:106px;'><tr><td><table style='height:20px;'><tr><td style='width:98px;font-family:Arial;font-size:8pt;'>$file</td><td style='width:30px;font-size:10pt;'>[<a class='cx_Link_RR' style='font-size:8pt;' href='./delete.php?encodingPath=$encodingPath&streamingPath=$streamingPath&file=$file'>Delete</a>]</td></tr></table></td></tr><tr><td><img src=\"".str_replace($_SERVER['DOCUMENT_ROOT'],'http://'.$_SERVER['SERVER_NAME'],$encodingPath)."/$snapshot\" width='140' height='78' border='1'></td></tr></table>\n";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 

	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<title>ClassX - Publishing Center</title>
	
	</head>
<body>

	<body>
		<h3 class="MainH2" style="font-family:Arial; margin-top:15px;margin-left:10px;">Video Files</h3>
		<h4 style="font-family:Arial;margin-left:20px;">Video health check result:</h4>
		<p style="font-family:Arial;margin-left:40px;font-size:10pt;font-weight:bold;">
		<?php
			if($input_video_healthy) {
				$info=explode('#',substr($vht_string,2));
				echo "<span style=\"color:rgb(0,180,0);\">Okay (duration:{$info[0]}, resolution:{$info[1]})</span>";
				if(sizeof($info)==3) echo $info[2];
			}
			else {
				echo "<span style=\"color:rgb(200,0,0);\">Failed. ".substr($vht_string,2)."</span>";
			}
			
		?>		
		</p>

		<h4 style="font-family:Arial;margin-left:20px; margin-top:15px;">Uploaded video files:</h4>
		<table style="margin-left:40px;">
		<?php
		if(sizeof($video_files)>0) {
			for($i=0;$i<sizeof($video_cells);$i++) {
			
				if($i%4 == 0) echo '<tr>';
				echo "<td>{$video_cells[$i]}</td>";
				if($i%4 == 3 || ($i==sizeof($video_cells)-1)) echo '</tr>';
			}
		}
		else {
			echo "<tr><td style='font-family:Arial;font-size:11pt;'>No video files have been uploaded yet for this session.</td></tr>";
		}
		?>
		</table>

		<h3 class="MainH2" style="font-family:Arial; margin-top:30px;margin-left:10px;">Presentation Files</h3>
		<h4 style="font-family:Arial;margin-left:20px;">Uploaded presentation files:</h4>
		<table style="margin-left:40px;">
		<?php
			if(sizeof($presentation_files)>0) {
				for($i=0;$i<sizeof($presentation_files);$i++) {
					echo "<tr><td style='width:200px;font-family:Arial;font-size:8pt;'>{$presentation_files[$i]}</td><td style='width:30px;font-family:Arial;font-size:8pt;'>[<a style='font-size:8pt;' href='./delete.php?encodingPath=$encodingPath&streamingPath=$streamingPath&file={$presentation_files[$i]}'>Delete</a>]</td></tr>\n";
				}
			}
			else {
				echo "<tr><td style='font-family:Arial;font-size:11pt;'>No presentation (.pdf) files have been uploaded yet for this session.</td></tr>";
			}
		?>
		</table>
	</body>
</html>
