<?php
class VideoUtil {
	public static function encode($videoName, $dstPath){
		if (file_exists($videoName)) {
			$baseName = basename($videoName, '.'.PHPHelper::getFileExtension($videoName));
			$dstPath = $dstPath.$baseName.'/';
			$curDir = dirName(__FILE__);
			$cmd = 'php '.$curDir.'/encode.php '.$videoName.' '.$baseName.' '.$dstPath.' > /dev/null 2>&1 &';
			exec($cmd);
			/*if (is_dir($dstPath))
			{
				shell_exec('rm -rf '.$dstPath);
			}
			mkdir($dstPath, 0755, true);
			exec('ffmpeg -i  '.$videoName.' -ac 1 -ab 128k -y -vcodec libx264 -vpre ultrafast -g 30 -r 30 -crf 22 '.$dstPath.$baseName.'.mp4  > /dev/null 2>&1 &'); 
			exec('ffmpeg -i  '.$videoName.' -ac 2 -ab 128k -y -acodec libvorbis -vcodec libtheora -g 30 -r 30 -crf 22 '.$dstPath.$baseName.'.ogv  > /dev/null 2>&1 &'); 
			
			//unlink($videoName);*/
			return $baseName;
		}
		else {
			throw new CException('file '.$videoName.'  not found');
		}
	}

	public static function isEncoding($contentId)
	{
		return false;
	}

	public static function isEncoded($contentId)
	{
		return false;
	}
}
?>
