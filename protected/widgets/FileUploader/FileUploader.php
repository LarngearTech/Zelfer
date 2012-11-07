<?php
class FileUploader extends BaseWidget
{
	public $config;

	function run()
	{
		$this->publishAssets(__DIR__);
		$this->render('fileuploader',
			array(
				'config'=>$this->config,
			)
		);
	}
}

?>
