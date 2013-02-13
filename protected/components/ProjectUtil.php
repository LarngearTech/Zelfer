<?php
class ProjectUtil
{
	static function contentComparator($a, $b)
	{
		if ($a->order == $b->order){
			return 0;
		}
		else{
			return ($a->order < $b->order)?-1:1;
		}
	}
}
?>
