<?php
class EditableContentList extends ContentListBase{
	public $course;

	function run(){
                $contents = $this->course->contents;
                usort($contents, array(__CLASS__, 'comparator'));

                // Publish required assets
                $cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery.ui');

		$this->render('editableContentList',
			array(
				'courseId'=>$this->course->id,
				'contents'=>$contents,
			)
		);
	}
}
?>
