<?php

Yii::import('ext.qtiprocessor.*');
require_once('QtiProcessor.php');

/**
 * Assessment widget
 */
class ZAssessmentItem extends CWidget
{
	const PROBLEM_MODE = 1;
	const RESULT_MODE = 2;

	// $id id for input
	public $id;

	// $item  QTI XML AssessmentItem path
	public $itemPath;

	// $mode rendering mode
	public $mode;

	public function init()
	{
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($assets.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css');

		// Set default mode to problem mode
		if ($this->mode === null)
		{
			$this->mode = self::PROBLEM_MODE;
		}
	}

	public function run()
	{
		$qp = new QtiProcessor();
		$item = $qp->parseAssessmentItem($this->itemPath);

		if ($this->mode == self::PROBLEM_MODE)
		{
			$this->render('problem', array(
				'id' => $this->id,
				'item' => $item,
			));
		}
		else if ($this->mode == self::RESULT_MODE)
		{
			$this->render('result', array(
				'id' => $this->id,
				'item' => $item,
			));
		}
	}
}
