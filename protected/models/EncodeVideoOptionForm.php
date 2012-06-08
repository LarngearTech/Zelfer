<?php
class EncodeVideoOptionForm extends CFormModel
{
	public $encodingPath;
	public $streamingPath;
	public $encode_video;
	public $format;
	public $sync_slides;
	public $scene_annotation_data;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lecture the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Define validating rule.
	 */
	public function rules()
	{
		return array(
			array('encodingPath, streamingPath, encode_video, format, sync_slides', 'required'),
			array('encodingPath, streamingPath, format, encode_video, sync_slides, scene_annotation_data', 'length'),
			array('format', 'in', 'range'=>array('openclassroom', 'classx')),
			array('encode_video, sync_slides', 'in', 'range'=>array('y', 'n'))
		);
	}
}
?>
