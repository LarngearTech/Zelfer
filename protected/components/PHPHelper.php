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
}
?>
