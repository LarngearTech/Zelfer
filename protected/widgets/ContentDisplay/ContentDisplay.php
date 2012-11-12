<?php
class ContentDisplay extends BaseWidget
{
	public $content;
	function init()
	{
		$this->publishAssets(__CLASS__);
	}
	function run()
	{
		if ($this->content)
		{
			if ($this->content->type == 1)
			{
				$this->render('noContent');
			}
			// content video
			else if ($this->content->type == 2)
			{
				$this->render('contentVideo', 
					array('content'=>$this->content));
			}
		}
	}
}
?>
