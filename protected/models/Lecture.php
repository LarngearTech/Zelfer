<?php

/**
 * This is the model class for table "lecture".
 *
 * The followings are the available columns in table 'lecture':
 * @property integer $id
 * @property string $name
 * @property integer $course_id
 */
class Lecture extends CActiveRecord
{
	const ENCODING_PATH_PREFIX = '/asset/encoding/';
	const STREAMING_PATH_PREFIX = '/asset/streaming/';
	const SLIDE_URL_PREFIX = '/asset/slide/';

	protected $encodingPath;
	protected $streamingPath;
	protected $slideUrl;

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
	 * @return whether or not title and description of lecture has been defined
	 */
	public function step1Complete()
	{
		return true;
	}

	/**
	 * @return state of the previously encoded input vdo
	 */
	public function inputVdoHealthy()
	{
		return true;
	}

	/**
	 * @return whether vdo encoding process has warning
	 */
	public function hasWarning()
	{
		return false;
	}

	/**
	 * @return whether input vdo can be encoded
	 */
	public function canEncode()
	{
		return true;
	}

	/**
	 * @return is there any previously encoded vdo
	 */
	public function isPreviouslyEncoded()
	{
		return true;
	}

	/**
	 * @return is there any ongoing encoding session
	 */
	public function isEncoding()
	{
		return true;
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
     	 * Post-processing after the record is instantiated by a find method.
     	 * Assign encoding and streaming paths for a lecture.
     	 */
    	protected function afterFind()
    	{
		parent::afterFind();
		$this->encodingPath = self::ENCODING_PATH_PREFIX.$this->id;
		$this->streamingPath = self::STREAMING_PATH_PREFIX.$this->id;
		$this->slideUrl = self::SLIDE_URL_PREFIX.$this->id;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lecture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, chapter_id', 'required'),
			array('chapter_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, chapter_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'chapter' => array(self::BELONGS_TO, 'Chapter', 'chapter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'chapter_id' => 'Chapter',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('chapter_id',$this->chapter_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return string lecture's encoding path
	 */
	public function getEncodingPath()
	{
		return $this->encodingPath;
	}

	/**
	 * @return string lecture's streaming path
	 */
	public function getStreamingPath()
	{
		return $this->streamingPath;
	}

	/**
	 * @return string lecture's slide URL
	 */
	public function getSlideUrl()
	{
		return $this->slideUrl;
	}
}
