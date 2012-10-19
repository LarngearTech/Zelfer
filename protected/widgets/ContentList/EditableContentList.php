<?php
class EditableContentList extends ContentListBase{
	public $course;
	public $addLectureHandler;
	public $addChapterHandler;

	function registerSortScript()
	{
		$cs = Yii::app()->getClientScript();
		$cs->registerScript('make-sort-script',
			"function makeSortable(){
				$('.content-list').sortable({
					handle : '.handle',
					update : function(){
						var contentList = $('.content-list').sortable();
						var order = $(contentList).sortable('serialize');
						$.ajax({
							url:'".Yii::app()->createUrl('course/changeContentOrder')."',
							data:order,
							dataType:'html',                
							type:'POST',
						});
					}       
				});
			};
			$(function(){
				makeSortable()
			});",
		CClientScript::POS_HEAD);
	}

	function run(){
		$this->registerSortScript();

                // Publish required assets
                $cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('editableContentList',
			array(
				'course'=>$this->course,
				'addLectureHandler'=>$this->addLectureHandler,
				'addChapterHandler'=>$this->addChapterHandler,
			)
		);
	}
}
?>
