<div>
	<span class="content-prefix"><?php echo $contentPrefix; ?></span>
	<span id="content-name-<?php echo $content->id; ?>" class="content-name"><?php echo $content->name; ?></span>
	<span class="edit-panel">
		<a class="btn content-edit" onclick="js:editContent(<?php echo $content->id; ?>, '<?php echo $contentPrefix?>')" title="edit content"><i class="icon-edit"></i></a>
		<a class="btn content-delete" onclick="js:deleteContent(<?php echo $content->id; ?>)" title="delete content"><i class="icon-trash"></i></a>
	</span>
</div>
