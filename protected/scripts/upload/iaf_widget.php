<?php

$encodingPath = $_GET["encodingPath"];
$streamingPath = $_GET["streamingPath"];

require_once 'in_a_flash/class.FlashUploader.php';
IAF_display_js();
$uploader = new FlashUploader('widgetDiv', 'in_a_flash/uploader', "/var/www/zelfer/protected/scripts/upload/in_a_flash/upload.php");

$uploader->pass_var('encodingPath', $encodingPath);
$uploader->pass_var('streamingPath', $streamingPath);

$uploader->display();
?>
<html>
<body>
</body>
</html>
