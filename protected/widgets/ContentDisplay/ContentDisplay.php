<?php
class ContentDisplay extends BaseWidget
{
	public $content;
	function init()
	{
		$this->publishAssets(__DIR__);
	}
	function run()
	{
		if ($this->content)
		{
			if ($this->content->type == Yii::app()->params["no_content"])
			{
				$this->render('noContent');
			}
			// content video
			else if ($this->content->type == Yii::app()->params["video_content"])
			{
				$this->render('contentVideo', 
					array('content'=>$this->content));
			}
			// quiz
			else if ($this->content->type == Yii::app()->params["quiz_content"])
			{
				$this->render('contentQuiz', 
					array('content'=>$this->content));
			}
		}
	}
}
?>
