<?php
foreach ($instructorList as $instructor)
{
	$this->widget($this->itemWidget, array('instructor'=>$instructor));
}
?>
