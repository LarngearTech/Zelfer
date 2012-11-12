<?php
class FileUploader extends BaseWidget
{
	public $config;

	function init()
	{
		$this->publishAssets(__DIR__);
	}

	function run()
	{
		$this->render('fileuploader',
			array(
				'config' => $this->config,
			)
		);
	}
}
