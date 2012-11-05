<?php
class EditableInstructorList extends CWidget{
	public $course;
	public $deleteInstructorHandler;
	public $update;
	public $itemWidget;

	function run()
	{
		if (empty($this->itemWidget))
		{
			$this->itemWidget = 'EditableInstructorListItem';
		}

		$this->render('editableInstructorList', array(
			'course' => $this->course,
			'deleteInstructorHandler' => $this->deleteInstructorHandler,
			'update' => $this->update,
			'itemWidget' => $this->itemWidget,
		));
	}
}
?>
