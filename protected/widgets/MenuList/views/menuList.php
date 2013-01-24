<?php
$hasGroupHeading = false;
$menuId = 1;

foreach ($menus as $menu)
{
	if ($menu['isGroupHeading'])
	{
		// Add closing tag of the previous group 
		if ($hasGroupHeading)
		{
			addGroupEnding();
			$hasGroupHeading = false;
		}
		addGroupHeading($menuId, $menu);
		$hasGroupHeading = true;
		
		$menuId++;
	}
	else
	{
		addSubmenu($menu);
	}
}
addGroupEnding();

function addGroupHeading($menuId, $menu)
{ 
	include('_groupHeading.php');

}

function addGroupEnding()
{
	include('_groupEnding.php');
}

function addSubmenu($menu)
{ ?>
	<li class="submenu">
		<a href="javascript:void(0)" 
			class="playbutton" 
			data-menuId=<?php echo $menu['id']; ?>
			name="<?php echo $menu['name']; ?>">
			<?php echo CHtml::encode($menu['name']);?>
		</a> 
	</li>
<?php
} ?>
