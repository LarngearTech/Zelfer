<?php
foreach ($instructorList as $instructor)
{
	$this->widget($this->listItemView, array('instructor'=>$instructor));
}
?>
