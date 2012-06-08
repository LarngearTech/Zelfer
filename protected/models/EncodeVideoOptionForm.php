<?php
class EncodeVideoOptionForm extends CFormModel
{
	public $encodingPath;
	public $streamingPath;
	public $encode_video;
	public $format;
	public $sync_slides;
	public $scene_annotation_data;

	public function rules()
	{
		return array(
			array('encodingPath, streamingPath, encode_video, format, sync_slides', 'required'),
			array('encodingPath, streamingPath, format, encode_video, sync_slides, scene_annotation_data', 'string'),
		);
	}
}
?>
