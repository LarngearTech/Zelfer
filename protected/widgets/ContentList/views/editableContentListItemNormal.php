<div>
	<span class="content-prefix"><?php echo $contentPrefix; ?></span>
	<span id="content-name-<?php echo $content->id; ?>" class="content-name"><?php echo $content->name; ?></span>
	<span class="edit-panel">
		<a class="btn content-edit" onclick="js:editContent(<?php echo $content->id; ?>, '<?php echo $contentPrefix?>')" title="<?php echo Yii::t('site', 'Edit');?>"><i class="icon-pencil"></i></a>
		<a class="btn content-delete" onclick="js:deleteContent(<?php echo $content->id; ?>)" title="<?php echo Yii::t('site', 'Delete');?>"><i class="icon-trash"></i></a>
	</span>
</div>
