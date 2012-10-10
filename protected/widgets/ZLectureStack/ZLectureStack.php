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
		// Get assets dir
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets', false, -1, YII_DEBUG);

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($assets.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style.css');
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
