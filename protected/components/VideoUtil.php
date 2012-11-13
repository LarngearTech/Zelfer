<?php
class VideoUtil {
	public static function encode($videoName, $dstPath){
		if (file_exists($videoName)) {
			$baseName = basename($videoName, '.'.PHPHelper::getFileExtension($videoName));
			$dstPath = $dstPath.$baseName.'/';
			if (is_dir($dstPath))
			{
				shell_exec('rm -rf '.$dstPath);
			}
			mkdir($dstPath, 0755, true);
			exec('ffmpeg -i  '.$videoName.' -ac 1 -ab 128k -y -vcodec libx264 -vpre ultrafast -g 30 -r 30 -crf 22 '.$dstPath.$baseName.'.mp4  > /dev/null 2>&1 &'); 
			exec('ffmpeg -i  '.$videoName.' -ac 2 -ab 128k -y -acodec libvorbis -vcodec libtheora -g 30 -r 30 -crf 22 '.$dstPath.$baseName.'.ogv  > /dev/null 2>&1 &'); 
			
			//unlink($videoName);
			return $baseName;
		}
		else {
			throw new CException('file '.$videoName.'  not found');
		}
	}
}
?>
