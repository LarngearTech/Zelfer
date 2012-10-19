<ul class='content-list'>
	<?php
		foreach($contents as $content)
		{
			echo '<li id="content_'.$content->id.'">'.$content->name.'<a class="handle">move</a></li>';
		}
	?>
</ul>
