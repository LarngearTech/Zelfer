<?php
class ContentListBase extends BaseWidget{
	
	function comparator($a, $b){
		if ($a->order == $b->order){
			return 0;
		}
		else{
			return ($a->order < $b->order)?-1:1;
		}
	}

	function init()
	{
		$this->publishAssets(__DIR__);
	}
}
?>
