<ul class='content-list'>
	<?php
		foreach($contents as $content)
		{
			$class=$content->isChapter()?'editable-chapter':'editable-lecture';
			echo 
			'<li id="content_'.$content->id.'" class="'.$class.'">'.
				'<input type="text" id="contentId_"'.$content->id.' value="'.$content->name.'"/>'.
				'<a class="handle">move</a>
			</li>';
		}
	?>
</ul>
