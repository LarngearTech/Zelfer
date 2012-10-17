<?php
class EditableInstructorListItem extends BaseWidget{
	public $course;
	public $instructor;
	public $deleteInstructorHandler;
	public $update;

	function run()
	{
		$this->publishAssets(Yii::getPathOfAlias('application.widgets.InstructorList'));

		// Render widget
		echo $this->render('editableInstructorListItem', 
			array(
			'course'=>$this->course,
			'instructor'=>$this->instructor,
			'deleteInstructorHandler'=>$this->deleteInstructorHandler,
			'update'=>$this->update,
		));
	}
}
?>
