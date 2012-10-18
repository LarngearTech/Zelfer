<?php
class ContentList extends BaseWidget{
	public $contents;
	public $mode;
	
	function comparator($a, $b){
		if ($a->order == $b->order){
			return 0;
		}
		else{
			return ($a->order < $b->order)?-1:1;
		}
	}
	
	function registerPlayButtonHandler(){
		$cs=Yii::app()->clientScript;
		$cs->registerScript(
			'playbutton-click',
			'$(function() {
				$("a.accordion-body .chapter").click(function(e) {
					alert(this.id);
				});
				$(".playbutton").click(function(e){
					ajaxUrl = "'.Yii::app()->controller->createUrl("course/changeVideo").'";
					$.ajax({
						url : ajaxUrl,
						data : {
							videoId : this.id
						},
						dataType : "html",
						success : function(html){$("#lecture-content-wrapper").html(html);}
					});
				});
			});',
			CClientScript::POS_END
		);
	}

	function run(){
		usort($this->contents, array(__CLASS__, 'comparator'));
		$this->publishAssets(Yii::getPathOfAlias('application.widgets.ContentList'));
		if (empty($this->mode))
		{
			$this->mode='normal';
		}

		if ($this->mode=='inclass')
		{
			$this->registerPlayButtonHandler();
		}

		$this->render('contentList',
			array(
				'mode'=>$this->mode,
				'contents'=>$this->contents,
				'assetsUrl'=>$this->assetsUrl,
			)
		);
	}
}
?>
