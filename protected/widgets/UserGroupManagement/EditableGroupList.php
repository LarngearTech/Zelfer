<?php
class EditableGroupList extends EditableGroupListBase{

	public $groups;

	function run(){

		usort($this->groups, array(__CLASS__, 'comparator'));

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('editableGroupList',
			array(
				'groups' => $this->groups,
			)
		);
	}
}
