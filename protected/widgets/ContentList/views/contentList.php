<?php
	$i=0;
	$j=0;
	foreach($contents as $content)
	{
		if ($content->parent_id == 0)
		{
			echo 'chapter '.$i.':'.$content->name.'</br>';
			$i++;
			$j=0;
		}
		else
		{
			echo 'lecture '.$j.':'.$content->name.'</br>';
			$j++;
		}
	}
?>
