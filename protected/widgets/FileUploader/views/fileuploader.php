<style>
.file-upload-btn
{
    position:relative;
    width:120px;
}

.file-name
{
    border:1px solid #E1E1E1;
    padding-top:0px;
    padding-left:4px;
    border-radius:3px;
    width:400px !important;
    display:inline-block;
    height:30px;
    vertical-align:middle;
    background:#F8F7F0;
}

.file-file
{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    opacity:0;
    filter:alpha(opacity=0);
}
</style>

<div class="file-uploader-container">
	<div class="file-name"><?php echo $config['placeholder']; ?></div>
	<a class="btn btn-primary file-upload-btn">
		<span><?php echo $config['btnLabel']; ?></span>
		<input class="file-file" id="<?php echo $config['id']; ?>" type="file"></input>
	</a>
</div>
