<?php
class PHPHelper
{
	public static function getFileFullName($filename)
	{
		return $this->getFileName($filename).'.'.$this->getFileExtension($filename);
	}
	public static function getFileName($filename)
	{
		return baseName($filename, '.'.$this->getFileExtension($filename));
	}
	public static function getFileExtension($filename)
	{
		$ext = end(explode('.', $filename));
		return $ext;
	}
}
?>
