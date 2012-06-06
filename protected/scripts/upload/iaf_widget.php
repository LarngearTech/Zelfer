<?php

$subject = sanitize_input($_GET["encodingPath"]);
$session = sanitize_input($_GET["streamingPath"]);

require_once 'in_a_flash/class.FlashUploader.php';
IAF_display_js();
$uploader = new FlashUploader('widgetDiv', 'in_a_flash/uploader',Yii::app()->baseUrl."/scripts/upload/in_a_flash/upload.php");

$uploader->pass_var('encodingPath', $encodingPath);
$uploader->pass_var('streamingPath', $streamingPath);

$uploader->display();
?>
<html>
<body>
</body>
</html>
