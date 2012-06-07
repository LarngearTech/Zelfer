<?php

$encodingPath = $_GET["encodingPath"];
$streamingPath = $_GET["streamingPath"];
$url=str_replace($_SERVER['DOCUMENT_ROOT'],'http://'.$_SERVER['SERVER_NAME'],realpath('.'));
$url = $url."/in_a_flash/upload.php";

require_once 'in_a_flash/class.FlashUploader.php';
IAF_display_js();
$uploader = new FlashUploader('widgetDiv', 'in_a_flash/uploader', $url);

$uploader->pass_var('encodingPath', $encodingPath);
$uploader->pass_var('streamingPath', $streamingPath);

$uploader->display();
?>
<html>
<body>
</body>
</html>
