<div>
	<span class="content-prefix"><?php echo $contentPrefix; ?></span>
	<span id="content-name-<?php echo $content->id; ?>" class="content-name">
		<input type="text" value="<?php echo $content->name; ?>"/>
	</span>
	<div>
		<h4>Add content's material</h4>
	</div>
	<div class="edit-panel">
		<a class="btn"><i class="icon-ok"></i></a>
		<a class="btn"><i class="icon-remove"></i></a>
		<a class="btn content-delete" onclick="js:deleteContent(<?php echo $content->id; ?>)" title="delete content"><i class="icon-trash"></i></a>
	</div>
</div>
