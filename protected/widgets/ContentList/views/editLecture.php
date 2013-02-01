<div>
	<div class="container">
		<div class="row">
			<div class="span7">
				<div class="span3">
					<img class="video-thumbnail" src="<?php echo ResourcePath::getContentBaseUrl().$content->id.'/video/thumbnail.jpg' ?>"/>
				</div>				

				<div class="span3">
					<div class="row">
						<div class="video-title">Test Lecture Video</div>
					</div>
					<div class="row">
						<div class="video-duration">00:45</div>
					</div>
					<div class="row">
						<div class="btn btn-danger" 
						onclick="js:deleteContentVideoAndRedirect(<?php echo $content->id.','.'\''.$contentPrefix.'\'';?>)"><?php echo Yii::t('site', 'delete'); ?></div>
					</div>	
				</div>
			</div>
		</div>
		<div class="row">
			<div class="span7">
				<hr>
			</div>
			<div class="span7">
			</div>
		</div>
		<?php
		$this->widget('MaterialList', array('content'=>$content));
		?>
		<div class="row">
			<div class="span7">
			<input class="btn btn-primary" type="button" 
				onclick="js:addSupplementaryMaterial(<?php echo $content->id;?>, '<?php echo $contentPrefix; ?>')" 
				value="<?php echo Yii::t('site', 'Add Supplementary Material'); ?>"/>
			</div>
		</div>
	</div>
</div>
