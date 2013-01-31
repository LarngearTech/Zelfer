<?php
$materials = $content->materials;
if(sizeof($materials) > 0)
{
?>
	<div class="material-list-wrapper">
		<div class="title"><?php echo Yii::t('site', 'Material List'); ?></div>
		<ul class="tag-list">
			<?php
			foreach($materials as $material){
			?>
				<li>
					<a><?php echo $material['name']; ?></a>
				</li>
			<?php
			}
			?>
		</ul>
	</div>
<?php
}
?>