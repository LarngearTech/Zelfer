<div>
	<span class="content-prefix"><?php echo $contentPrefix; ?></span>
	<span id="content-name-<?php echo $content->id; ?>" class="content-name">
		<input id="txt-content-name-<?php echo $content->id; ?>" type="text" value="<?php echo $content->name; ?>"/>
	</span>
	<div class="edit-panel">
		<a class="btn commit-content" onclick="js:commitContent(
			<?php echo $content->id; ?>,
			'<?php echo $contentPrefix; ?>'
			)" title="commit change">
			<i class="icon-ok"></i>
		</a>
		<a class="btn cancel-edit-edit" onclick="js:cancelEditContent(<?php echo $content->id; ?>, '<?php echo $contentPrefix; ?>')" title="reset"><i class="icon-remove"></i></a>
		<a class="btn delete-content" onclick="js:deleteContent(<?php echo $content->id; ?>)" title="delete content"><i class="icon-trash"></i></a>
	</div>
	<?php
	if (!$content->isChapter())
	{
?>
	<div id="edit-content-body-<?php echo $content->id; ?>" class="edit-content-body">
		<?php $this->render('addContentMaterial',
			array("contentId"=>$content->id)); ?>
	</div>
<?php
	}
	?>
</div>
