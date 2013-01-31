<?php
class MaterialList extends ContentListBase{
	public $content;
	
	function run(){

		$this->render('materialList',
			array(
				'content'=>$this->content,
			)
		);
	}
}
?>
