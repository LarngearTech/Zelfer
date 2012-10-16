<?php
/**
 * Assessment widget
 */
class ZAssessment extends CWidget
{
	/* lecture id that this assessment is belong to */
	public $lectureId;
	/* user id of student */
	public $userId;
	/* headline text of this assessment */
	public $headline;
	/* description of this assessment */
	public $description;
	// $itemIds Array of assessment items (id, xmlPath)
	public $items;

	public function init()
	{
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('jquery.ui');
		$cs->registerCssFile($assets.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css');
		$cs->registerCssFile($assets.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'jPaginator.css');
		$cs->registerScriptFile($assets.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'jPaginator.min.js');
		$cs->registerScript(
			'paginator',
			"$(function () {
				$('.assessment-item').hide();
				$('#assessment-test-1').show();
				$('#paginator-control').jPaginator({
					nbPages: 4,
					selectedPage: 1,
					overBtnLeft: '#paginator_o_left',
					overBtnRight: '#paginator_o_right',
					maxBtnLeft: '#paginator_m_left',
					maxBtnRight: '#paginator_m_right',
					minSlidersForSlider: 5,
					onPageClicked: function(a, num) {
						$('.assessment-item').hide();
						$('#assessment-test-' + num).show();
					},
				});
			});",
			CClientScript::POS_END
		);
	}

	public function run()
	{
		// user submits data
		if (isset($_POST['test-1']))
		{
			echo 'posted!'.$_POST['test-1']; exit();
		}

		$this->render('ZAssessment', array(
			'lectureId' => $this->lectureId,
			'userId' => $this->userId,
			'headline' => $this->headline,
			'description' => $this->description,
			'items' => $this->items,
		));
	}
}
