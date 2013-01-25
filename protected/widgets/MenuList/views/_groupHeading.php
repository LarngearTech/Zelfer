<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#menu-accordion" href="#menu<?php echo $menu['id']; ?>-collapse">
			<?php echo CHtml::encode($menu['name']); ?>
		</a>
	</div><!-- .accordion-heading -->
	<div id="menu<?php echo $menu['id']?>-collapse" class="accordion-body collapse in">
		<div class="accordion-inner">
			<ul>