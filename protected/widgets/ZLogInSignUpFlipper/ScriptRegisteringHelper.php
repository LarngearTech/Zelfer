<?php
class ScriptRegisteringHelper
{
	public static function registerScript($jsFileName)
	{
		if (!Yii::app()->clientScript->isScriptFileRegistered(
				Yii::app()->baseUrl.'/js/'.$jsFileName))
		{
			$jsFilePath = dirname(__FILE__).'/assets/js/'.$jsFileName;
			$jsFile = Yii::app()->getAssetManager()->publish($jsFilePath);
			Yii::app()->clientScript->registerScriptFile($jsFile);
		}
	}
}
