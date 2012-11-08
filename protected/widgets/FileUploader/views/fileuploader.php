<div class="file-uploader-container">
	<div class="file-name progress progress-info progress-striped">
		<span id="<?php echo $config['id']?>-label" class="file-name-text"><?php echo $config['placeholder']; ?></span>
		<div class="bar" style="width: 60%"></div>
	</div>
	<div class="btn btn-primary file-upload-btn" onclick="js:btnFileUploaderClick('<?php echo $config['id']; ?>');">
		<span><?php echo $config['btnLabel']; ?></span>
		<input class="file-file" 
			id="<?php echo $config['id']; ?>" 
			type="file"
		>
		</input>
	</div>
</div>
