<?php
	@extract($_GET);
	
	$filename	= $_FILES['Filedata']['name'];
	$temp_name	= $_FILES['Filedata']['tmp_name'];
	$error		= $_FILES['Filedata']['error'];
	$size		= $_FILES['Filedata']['size'];
	

	/* Extract file's destination path */
	$encodingPath     = $_GET["encodingPath"];
	$streamingPath    = $_GET["streamingPath"];

	/* NOTE: Some server setups might need you to use an absolute path to your "dropbox" folder
	(as opposed to the relative one I've used below).  Check your server configuration to get
	the absolute path to your web directory*/
	if(!$error) {
		if (!is_dir($encodingPath))
		{
			if (!mkdir($encodingPath, 0777, true) || !mkdir($streamingPath, 0777, true))
			{
				die('Failed to create '.$encodingPath.' folders...'); 
			}
		}
		move_uploaded_file($temp_name, "$encodingPath/$filename");
		//system("chmod 770 \"$encodingPath/$filename\"");
	}
	echo '1';
	echo $encodingPath;
?>
