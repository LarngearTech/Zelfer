<ul class='content-list'>
	<?php
		foreach($contents as $content)
		{
			$class=$content->isChapter()?'editable-chapter':'editable-lecture';
			echo 
			'<li id="content_'.$content->id.'" class="'.$class.'">
				'.$content->name.'
				<span class="edit-panel">
					<a class="btn content-edit"><i class="icon-edit"></i></a>
					<a class="btn content-delete"><i class="icon-remove"></i></a>
				</span>
			</li>';
		}
	?>
</ul>
