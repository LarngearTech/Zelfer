<?php

Yii::import('ext.qtiprocessor.*');
require_once('QtiProcessor.php');

/**
 * Assessment widget
 */
class ZAssessmentItem extends CWidget
{
	//$id id for input
	public $id;

	//$item  QTI XML AssessmentItem path
	public $itemPath;

	public function init()
	{
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($assets.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css');
	}

	public function run()
	{
		$qp = new QtiProcessor();
		$items = $qp->parseAssessmentItems($this->itemPath);
		$this->render('ZAssessmentItem', array(
			'id' => $this->id,
			'item' => $items[0],
		));
	}
}
