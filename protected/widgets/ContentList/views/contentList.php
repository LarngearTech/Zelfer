<?php
	$hasHeading=false;
	$chapterId=1;

	foreach($contents as $content)
	{
		if ($content->isChapter())
		{
			// Add closing tag
			if ($hasHeading){
				addChapterEnding();
				$hasHeading=false;
			}
			addChapterHeading($chapterId, $content);
			$hasHeading=true;
			
			$chapterId++;
		}
		else
		{
			if ($mode == 'normal'){
				addContent($content);
			}
			else{
				addInClassContent($content, $assetsUrl);
			}
		}
	}
	addChapterEnding();
?>

<?php
function addChapterHeading($chapterId, $content)
{
?>
<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#chapter-accordion" href="#chapter<?php echo $chapterId; ?>-collapse">
			<?php echo Yii::t('site', 'Chapter').' '.$chapterId.' '.CHtml::encode($content->name); ?>
		</a>
	</div><!-- heading -->
	<div id="chapter<?php echo $chapterId?>-collapse" class="accordion-body collapse in">
		<div class="accordion-inner">
			<ul>
<?php
}
?>

<?php
function addChapterEnding()
{
?>
			</ul>
		</div><!-- inner -->
	</div><!-- body -->
</div><!-- group -->
<?php
}
?>

<?php
function addContent($content)
{
?>
	<li><?php echo CHtml::encode($content->name); ?></li>
<?php
}
?>

<?php
function addInClassContent($content, $assetsUrl)
{
?>
	<li class="lecture">
		<a href="javascript:void(0)" 
			class="playbutton" 
			id='<?php echo Yii::app()->baseUrl.'/content/'.$content->id.'/';?>' 
			name='<?php echo $content->name; ?>'>
		<?php echo CHtml::encode($content->name);?>
			<em>
				<img src="<?php echo $assetsUrl;?>/img/play.png"/>
			</em>
		</a> 
	</li>
<?php
}
?>
