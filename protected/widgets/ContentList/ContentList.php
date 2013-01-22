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
					$("#lecture-name").html(this.name);
					$("#lecture-content-wrapper").html(
						"<img width=\'100%\' src=\''.$this->assetsUrl.'/img/loading.gif\'/>"
					);
					ajaxUrl = "'.Yii::app()->controller->createUrl("course/changeContent").'";
					contentId = $(this).attr("data-contentId");
					$.ajax({
						url : ajaxUrl,
						data : {
							contentId : contentId 
						},
						type:"POST",
						dataType : "html",
						success : function(html){
							$(".lecture-content-wrapper").html(html);
							$(".assessment-item").hide();
							$("#assessment-test-0").show();
							$("#paginator-control").jPaginator({
								nbPages: 4	,
								selectedPage: 1,
								overBtnLeft: "#paginator_o_left",
								overBtnRight: "#paginator_o_right",
								maxBtnLeft: "#paginator_m_left",
								maxBtnRight: "#paginator_m_right",
								minSlidersForSlider: 5,
								onPageClicked: function(a, num) {
									alert("hello");
									$(".assessment-item").hide();
									$("#assessment-test-" + num).show();
								},
							});
						}
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
