<?php
class BaseWidget extends CWidget{
	public $assetsUrl;
	public $htmlOptions;
	public $options;
	
	public function publishAssets($widgetPath)
	{
		if(file_exists($widgetPath.'/assets'))
		{
			//$webroot = Yii::getPathOfAlias('webroot').'/..';
			$webroot = Yii::getPathOfAlias('webroot');
			echo $webroot; exit();
			$this->assetsUrl = Yii::app()->getAssetManager()->publish($widgetPath.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);
			$cs = Yii::app()->getClientScript();

			// Register javascript
			$jsroot = $webroot.$this->assetsUrl.'/js';
			//$jsroot = $this->assetsUrl.'/js';
			//echo $jsroot; exit();
			if(file_exists($jsroot))
			{
				$jsItr = new DirectoryIterator($jsroot);
				foreach ($jsItr as $js)
				{
					if(!$js->isDot() && !$js->isDir())
					{
						$cs->registerScriptFile($this->assetsUrl.'/js/'.$js->getFileName());		
					}
				}	
			}

			// Register css
			//$cssroot = $webroot.$this->assetsUrl.'/css';
			$cssroot = $this->assetsUrl.'/css';
			if(file_exists($cssroot))
			{
				$cssItr = new DirectoryIterator($cssroot);
				foreach ($cssItr as $css)
				{
					if (!$css->isDot() && !$css->isDir())
					{
						$cs->registerCssFile($this->assetsUrl.'/css/'.$css->getFileName());
					}
				}
			}
		}
	}

}
?>
