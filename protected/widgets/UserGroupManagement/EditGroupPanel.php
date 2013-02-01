<?php
class EditGroupPanel extends BaseWidget
{
	public $groups;
	public $addGroupHandler;
	public $addSubgroupHandler;

	function run()
	{
		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('editGroupPanel',
			array(
				'groups' => $this->groups,
				'addGroupHandler'=>$this->addGroupHandler,
				'addSubgroupHandler'=>$this->addSubgroupHandler,
			)
		);
	}
}
