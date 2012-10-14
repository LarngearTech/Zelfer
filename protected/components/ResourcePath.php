<?php
class ResourcePath
{
	public static function getCourseThumbnailBasePath()
	{
		return Yii::app()->basePath.'/../course/thumbnails';
	}
	public static function getCourseThumbnailBaseUrl()
	{
		return Yii::app()->baseUrl.'/course/thumbnails';
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
