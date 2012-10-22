<ul class='content-list'>
	<?php
		foreach($contents as $content)
		{
			$class=$content->isChapter()?'chapter-item':'lecture-item';
			echo 
			'<li id="content_'.$content->id.'" class="'.$class.'">'.
				$content->name.
				'<a class="handle">move</a>
			</li>';
		}
	?>
</ul>
