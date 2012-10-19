<?php
class ContentList extends ContentListBase{
	public $course;
	public $mode;
	
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
		$contents = $this->course->contents;
		usort($contents, array(__CLASS__, 'comparator'));

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
				'contents'=>$contents,
				'assetsUrl'=>$this->assetsUrl,
			)
		);
	}
}
?>
