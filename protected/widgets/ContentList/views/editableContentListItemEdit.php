<div>
	<span class="content-prefix"><?php echo $contentPrefix; ?></span>
	<span id="content-name-<?php echo $content->id; ?>" class="content-name">
		<input id="txt-content-name-<?php echo $content->id; ?>" type="text" value="<?php echo $content->name; ?>"/>
	</span>
<?php
	if (!$content->isChapter())
	{
?>
	<div>
		<h4>Add content's material</h4>
	</div>
<?php
	}
?>
	<div class="edit-panel">
		<a class="btn">
			<i class="icon-ok"
				onclick="js:commitContent(
					<?php echo $content->id; ?>,
					'<?php echo $contentPrefix; ?>'
				)" title="commit change">
			</i>
		</a>
		<a class="btn content-cancel-edit" onclick="js:cancelEditContent(<?php echo $content->id; ?>, '<?php echo $contentPrefix; ?>')" title="reset"><i class="icon-remove"></i></a>
		<a class="btn content-delete" onclick="js:deleteContent(<?php echo $content->id; ?>)" title="delete content"><i class="icon-trash"></i></a>
	</div>
</div>
