<?php
class MenuList extends MenuListBase
{
	public $menus;

	function run()
	{
		$menus = $this->menus;

		$this->render('menuList', 
			array(
				'menus' => $menus,
			)
		);
	}
}