<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript(
	'make-sort-script',
	"function makeSortable()
	{
		$('.group-list').sortable({
			//handle : '.group-handle',
			update : function(){
				var groupList = $('.group-list').sortable();
				var order = $(groupList).sortable('serialize');
				$.ajax({
					url:'".Yii::app()->createUrl('userGroup/changeGroupOrder')."',
					data:order,
					dataType:'html',                
					type:'POST',
					success:function(html){
						$('.editable-group-list-container').html(html);
						makeSortable();
					}
				});
			}       
		});
	};
	$(function(){
		makeSortable();
	});",
	CClientScript::POS_END);
?>
<h2><?php echo Yii::t('site', 'Group Management');?></h2>
<div class="well clearfix">
	<div class='editable-group-list-container'>
		<?php $this->widget('EditableGroupList', array(
			'groups' => $groups,
		));?>
	</div>
</div><!-- /well -->
<div class='btn-group add-group-panel'>
	<?php 
	echo CHtml::ajaxButton(
		Yii::t('site', 'Add Group'),
		$addGroupHandler,
		array(
			'type' => 'POST',
			'dataType' => 'html',
			'success' => 'function(html) {
				$(".editable-group-list-container").html(html);
				makeSortable();
			}'
		),
		array(
			'class' => 'btn btn-add-group',
		)
	);
	?>
	<?php 
	echo CHtml::ajaxButton(
		Yii::t('site', 'Add Subgroup'),
		$addSubgroupHandler,
		array(
			'type'=>'POST',
			'dataType'=>'html',
			'success'=>'function(html){
				$(".editable-group-list-container").html(html);
				makeSortable();
			}'
		),
		array(
			'class'=>'btn btn-add-lecture',
		)
	);
	?>
</div>
