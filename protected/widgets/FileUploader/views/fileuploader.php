<div class="file-uploader-container">
	<div id="<?php echo $config['id'];?>-progressbar-container" class="file-name progress progress-info progress-striped active">
		<span id="<?php echo $config['id']; ?>-label" class="file-name-text" data-placeholder="<?php echo $config['placeholder']; ?>"><?php echo $config['placeholder']; ?></span>
		<div id="<?php echo $config['id']; ?>-progressbar" class="bar" style="width: 0%"></div>
	</div>
	<div id="<?php echo $config['id'];?>-upload-btn" class="btn btn-primary file-upload-btn">
		<span><?php echo $config['btnLabel']; ?></span>
		<input class="file-file" 
			id="<?php echo $config['id']; ?>" 
			type="file"
			data-url="<?php echo $config['url']; ?>"
			data-deleteUrl="<?php echo $config['deleteUrl']; ?>"
			onchange="js:fileUploaderChangeHandler('<?php echo $config['id'];?>')"
		>
		</input>
	</div>
	<div id="<?php echo $config['id'];?>-delete-btn" class="btn btn-danger file-delete-btn" style="display:none" onclick="js:deleteUploadedFile('<?php echo $config['id'];?>')">
		<span><?php echo Yii::t('site', 'delete'); ?></span>
	</div>
	<div id="<?php echo $config['id'];?>-upload-cancel-btn" class="btn btn-danger file-upload-cancel-btn" style="display:none;">
		<span><?php echo Yii::t('site', 'cancel'); ?></span>
	</div>
</div>
