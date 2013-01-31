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
	public static function getFilesInFolder($foldername)
	{
		if ($handle = opendir($foldername))
		{
			$files=array();
			while (false !== ($entry = readdir($handle)))
			{
				if ($entry != "." && $entry != "..")
				{
					$files[]=array('name'=>$entry,
						'size'=>filesize($foldername.'/'.$entry));
				}
			}
			closedir($handle);
			return $files;
		}
		else
		{
			return array();
		}
	}
	public static function toMB($filesize)
	{
		$filesize = $filesize/1000000;
		return number_format($filesize,'2','.',',');
	}
	public static function rrmdir($dir)
	{
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
