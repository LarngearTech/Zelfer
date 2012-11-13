<?php
class PHPHelper
{
	public static function getFileFullName($filename)
	{
		return PHPHelper::getFileName($filename).'.'.PHPHelper::getFileExtension($filename);
	}
	public static function getFileName($filename)
	{
		return baseName($filename, '.'.PHPHelper::getFileExtension($filename));
	}
	public static function getFileExtension($filename)
	{
		$ext = end(explode('.', $filename));
		return $ext;
	}
	public static function rrmdir($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
				rrmdir($file);
			else
				unlink($file);
		}
    		rmdir($dir);
	}
}
?>
