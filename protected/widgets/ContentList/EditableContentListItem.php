<?php
class EditableContentListItem extends ContentListBase{
	public $contentPrefix;
	public $content;
	public $mode;

	function run(){
		if (!$this->mode)
		{
			$this->render('editableContentListItemNormal',
				array(
					'contentPrefix'=>$this->contentPrefix,
					'content'=>$this->content,
				)
			);
		}
		else if($this->mode == 'edit')
		{
			$this->render('editableContentListItemEdit',
				array(
					'contentPrefix'=>$this->contentPrefix,
					'content'=>$this->content,
				)
			);
		}
	}
}
?>
