<?php
class ContentList extends BaseWidget{
	public $contents;
	
	function comparator($a, $b){
		if ($a->order == $b->order){
			return 0;
		}
		else{
			return ($a->order < $b->order)?-1:1;
		}
	}
	
	function run(){
		usort($this->contents, array(__CLASS__, 'comparator'));
		$this->publishAssets(Yii::getPathOfAlias('application.widgets.ContentList'));

		$this->render('contentList',
			array(
				'contents'=>$this->contents,
			)
		);
	}
}
?>
