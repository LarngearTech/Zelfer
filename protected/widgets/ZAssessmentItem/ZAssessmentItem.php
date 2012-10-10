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
