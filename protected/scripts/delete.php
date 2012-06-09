<?php

// Get subject information
$encodingPath	= $_GET["encodingPath"];
$streamingPath	= $_GET["streamingPath"];
$file			= $_GET["file"];			

if(strlen($file)>3) {
	if(file_exists("$encodingPath/$file")) {
		system("rm \"$encodingPath/$file\"");
		// Delete the file's snapshot if it has one
		$snapshot=substr("$encodingPath/$file",-3)."jpg";
		if(file_exists($snapshot)) {
			system("rm \"$snapshot\"");
		}
	}
}

header("Location:file_summary.php?encodingPath=$encodingPath&streamingPath=$streamingPath");

?>
