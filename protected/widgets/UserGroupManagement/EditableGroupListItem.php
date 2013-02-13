<?php
class EditableGroupListItem extends EditableGroupListBase{
	public $groupPrefix;
	public $group;
	public $mode;

	function run()
	{
		if (!$this->mode || $this->mode == 'normal')
		{
			$this->render('editableGroupListItemNormal',
				array(
					'groupPrefix' => $this->groupPrefix,
					'group' => $this->group,
				)
			);
		}
		else if ($this->mode == 'edit')
		{
			$this->render('editableGroupListItemEdit',
				array(
					'groupPrefix' => $this->groupPrefix,
					'group' => $this->group,
					'users' => $this->group->users,
				)
			);
		}
	}
}
