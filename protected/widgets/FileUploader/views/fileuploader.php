<div class="file-uploader-container">
	<div class="file-name progress progress-info progress-striped active">
		<span id="<?php echo $config['id']; ?>-label" class="file-name-text" data-placeholder="<?php echo $config['placeholder']; ?>"><?php echo $config['placeholder']; ?></span>
		<div id="<?php echo $config['id']; ?>-progressbar" class="bar" style="width: 0%"></div>
	</div>
	<div id="<?php echo $config['id'];?>-upload-btn" class="btn btn-primary file-upload-btn">
		<span><?php echo $config['btnLabel']; ?></span>
		<input class="file-file" 
			id="<?php echo $config['id']; ?>" 
			type="file"
			data-url="<?php echo $config['url']; ?>"
			onchange="js:fileUploaderChangeHandler('<?php echo $config['id'];?>')"
		>
		</input>
	</div>
	<div id="<?php echo $config['id'];?>-upload-cancel-btn" class="btn btn-danger file-upload-cancel-btn" style="display:none;">
		<span>cancel</span>
	</div>
</div>
