<?php
class PHPHelper
{
	public static function getFileExtension($filename)
	{
		$ext = end(explode('.', $filename));
		return $ext;
	}
	public static function getIntroVideoBasePath()
	{
		return Yii::app()->basePath.'/../course/intros/';
	}
	public static function getIntroVideoBaseUrl()
	{
		return Yii::app()->baseUrl.'/course/intros/';
	}
}
?>
