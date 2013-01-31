<?php
	$materials = $content->materials;
	if (sizeof($materials) > 0) {
?>
		<div id="material-list-<?php echo $content->id; ?>" class="material-list">
			<div class="title">
				<?php echo Yii::t('site', 'Material List'); ?>
			</div>
			<table>
					<tr class="yellow"> 
						<td class="width"><?php echo Yii::t('site', 'Material Name'); ?></td>
						<td class="adjacent"><?php echo Yii::t('site', 'Size'); ?></td>
						<td class="adjacent"></td>
					</tr>
			<?php
				foreach ($materials as $material) {
			?>
					<tr>
						<td class="width"><?php echo $material['name']; ?></td>
						<td class="adjacent"><?php echo PHPHelper::toMB($material['size']); ?>MB</td>
						<td class="adjacent">
							<div class="clickable" onclick="js:deleteSupplementaryMaterial(
								<?php echo $content->id; ?>,'<?php echo $material['name']; ?>'
							)">
								<i class="icon-trash"></i>
							</div>
						</td>
					</tr>
			<?php
				}
			?>
			</table>
		</div>
<?php
	}
?>