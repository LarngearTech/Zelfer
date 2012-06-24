<?php $this->beginContent('//layouts/main'); ?>
<div class="row-fluid">
	<!-- content -->
	<div id="content" class="span9">
		<?php echo $content; ?>
	</div><!-- end content -->
	<!-- sidebard -->
	<div id="sidebar" class="span3 last">
		<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
		?>
	</div><!-- end sidebar -->
</div>
<?php $this->endContent(); ?>
