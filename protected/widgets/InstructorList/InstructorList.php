<?php
class InstructorList extends CWidget{
	public $instructorList;
	public $listItemView;

	function run()
	{
		if (empty($listItemView))
		{
			$this->listItemView = 'InstructorListItem';
		}

		$this->render('instructorList', 
			array(
			'instructorList' => $this->instructorList,
			'listItemView' => $this->listItemView,
			)
		);
	}
}
?>
