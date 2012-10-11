<?php
class VideoUtil {
	public static function encode($videoName, $dstPath){
		if (file_exists($videoName)) {
			$baseName = basename($videoName, '.'.PHPHelper::getFileExtension($videoName));
			$dstPath = $dstPath.$baseName.'/';
			mkdir($dstPath, 0755, true);
			shell_exec('ffmpeg -i  '.$videoName.' -ac 1 -ab 128k -y -vcodec libx264 -vpre ultrafast -g 30 -r 30 -crf 22 '.$dstPath.$baseName.".mp4"); 
			shell_exec('ffmpeg -i  '.$videoName.' -ac 1 -ab 128k -y -vcodec libtheora -g 30 -r 30 -crf 22 '.$dstPath.$baseName.".ogv"); 
			unlink($videoName);
			return $baseName;
		}
		else {
			throw new CException('file '.$videoName.'  not found');
		}
	}
}
?>