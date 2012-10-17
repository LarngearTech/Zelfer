<?php
class InstructorList extends CWidget{
	public $instructorList;
	public $itemWidget;

	function run()
	{
		if (empty($this->itemWidget))
		{
			$this->itemWidget = 'InstructorListItem';
		}

		$this->render('instructorList', 
			array(
			'instructorList' => $this->instructorList,
			'itemWidget' => $this->itemWidget,
			)
		);
	}
}
?>
