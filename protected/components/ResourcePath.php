<?php
class ResourcePath
{
	public static function getContentBasePath()
	{
		return Yii::app()->basePath.'/../contents/';
	}
	public static function getContentBaseUrl()
	{
		return Yii::app()->baseUrl.'/contents/';
	}
	public static function getCourseThumbnailBasePath()
	{
		return Yii::app()->basePath.'/../course/thumbnails/';
	}
	public static function getCourseThumbnailBaseUrl()
	{
		return Yii::app()->baseUrl.'/course/thumbnails/';
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
