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
	const VIDEO_URL_PREFIX = '/asset/video/';

	/**
	 * @var boolean whether title and description of lecture has been defined.
	 */
	public $step1Complete;
	
	/**
	 * @var boolean true if input video was successfully encoded, false otherwise.
	 */
	public $inputVideoHealthy;

	/**
	 * @var string error message from video encoding process.
	 */
	public $videoCheckError;

	/**
	 * @var whether a video encoding process finish without.
	 */
	public $hasWarning;

	/**
	 * @var string warning message from video encoding process.
	 */
	public $warningMessage;

	/**
	 * @var boolean shortcut for step1Complete && inputVideoHealty.
	 */
	public $canEncode;

	/**
	 * @var boolean is there any previously encoded video files.
	 */
	public $isPreviouslyEncoded;

	/**
	 * @var boolean is ther any ongoing encoding sessions.
	 */
	public $isEncoding;

	protected $_encodingPath;
	protected $_streamingPath;
	protected $_slideUrl;
	protected $_videoUrl;


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
	 * init member variables
	 */
	public function init()
	{
		$this->initWithId($this->id);
	}

	/**
	 * init member variables and check vdo status for specified lectureId
	 * @param int lectureId
	 */
	public function initWithId($id)
	{
		$this->_encodingPath 	= self::ENCODING_PATH_PREFIX.$id;
		$this->_streamingPath 	= self::STREAMING_PATH_PREFIX.$id;
		$this->_slideUrl 	= self::SLIDE_URL_PREFIX.$id;
		$this->_videoUrl	= self::VIDEO_URL_PREFIX.$id;

		$this->step1Complete	= file_exists($this->streamingPath."/SessionDescription.txt");

		$scriptRoot = Yii::app()->basePath."/scripts";
		$vhtString=exec("perl $scriptRoot/video_health_check.pl \"$this->encodingPath\"",$retval);
		$this->inputVideoHealthy	= (substr($vhtString,0,1)=='1');;
		if(!$this->inputVideoHealthy) 
		{
			$this->videoCheckError=substr($vhtString,2);
		}
		else
		{
			$this->hasWarning=(strpos($vhtString,'Warning')==true);
			if($this->hasWarning)
			{
				$elements=explode('#',$vhtString);
				$this->warningMessage=$elements[2];
			}
		}

		$this->canEncode=$this->inputVideoHealthy && $this->step1Complete;
		$this->isPreviouslyEncoded=file_exists("$this->streamingPath/video_complete.txt");
		$this->isEncoding=(file_exists("$this->streamingPath/video_encoding.txt") 
				|| file_exists("$this->streamingPath/slide_encoding.txt"));
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
		$this->initWithId($this->id);
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
			'course' => array(self::HAS_ONE, 'Course', array('course_id'=>'id'), 'through'=>'chapter'),
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
		return $this->_encodingPath;
	}

	/**
	 * @return string lecture's streaming path
	 */
	public function getStreamingPath()
	{
		return $this->_streamingPath;
	}

	/**
	 * @return string lecture's slide URL
	 */
	public function getSlideUrl()
	{
		return $this->_slideUrl;
	}
	
	/**
	 * @return string lecture's video URL
	 */
	public function getVideoUrl()
	{
		return $this->_videoUrl;
	}
}
