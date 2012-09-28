<?php
/**
 * Lecture stack widget
 */
class ZLectureStack extends CWidget
{
	// Course that this lecture stack belong to
	public $courseModel;

	// Chapters in this course
	public $chapters;

	public function init()
	{
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.widgets.ZLectureStack.assets.css').'/style.css'));
		//$cs->registerScriptFile(Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.widgets.ZLectureStack.assets.js').'/script.js'));
		$cs->registerScript(
			'playbutton-click',
			'$(document).ready(function() {
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

	public function run()
	{
		$this->render('ZLectureStack', array(
			'chapters' => $this->chapters,
		));
	}
}
