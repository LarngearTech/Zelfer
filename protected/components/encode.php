<?php
$videoName = $argv[1];
$baseName = $argv[2];
$dstPath = $argv[3];

if (is_dir($dstPath))
{
	shell_exec('rm -rf '.$dstPath);
}
mkdir($dstPath, 0755, true);

// Generate thumbnail
exec('ffmpeg -i '.$videoName.' -ss 00:00:00 -f image2 -vframes 1 '.$dstPath.'/thumbnail.jpg');

// Start encoding
shell_exec('touch '.$dstPath.'/encoding.txt');
exec('ffmpeg -i  '.$videoName.' -ac 1 -ab 128k -y -vcodec libx264 -vpre ultrafast -g 30 -r 30 -crf 22 '.$dstPath.$baseName.'.mp4');
exec('ffmpeg -i  '.$videoName.' -ac 2 -ab 128k -y -acodec libvorbis -vcodec libtheora -g 30 -r 30 -crf 22 '.$dstPath.$baseName.'.ogv');

// Remove temporary directory
shell_exec('rm -rf '.$dstPath.'/../tmp');
shell_exec('rm '.$dstPath.'/encoding.txt');

// Mark encoding complete
shell_exec('touch '.$dstPath.'/complete.txt');
?>
