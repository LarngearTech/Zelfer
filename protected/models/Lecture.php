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
	const ENCODING_PATH_PREFIX = '/contents/encoding/';
	const STREAMING_PATH_PREFIX = '/contents/streaming/';
	const SLIDE_URL_PREFIX = '/contents/slide/';
	const VIDEO_URL_PREFIX = '/contents/video/';
	const DEFAULT_PLAYER_WIDTH = 700;
	const DEFAULT_PLAYER_HEIGHT = 525;

	/**
	 * @var boolean whether title and description of lecture has been defined.
	 */
	public $step1Complete;
	
	/**
	 * @var boolean true if input video was successfully encoded, false otherwise.
	 */
	public $inputVideoHealthy;

	/**
	 * @var array additional input video information retrieved from video_health_check.pl script.
	 */
	public $inputVideoInfo;

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
	protected $_thumbnailUrl;


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
		$this->_encodingPath 	= "";
		$this->_streamingPath 	= "";
		$this->_slideUrl 	= "";
		$this->_videoUrl	= "";

		$this->step1Complete	= false;
		$this->inputVideoHealthy= false;
		$this->inputVideoInfo	= array();
		$this->videoCheckError	= "";
		$this->hasWarning	= false;
		$this->warningMessage	= "";
		$this->canEncode	= false;
		$this->isPreviouslyEncoded = false;
		$this->isEncoding	= false;
	}

	/**
	 * init member variables and check vdo status for specified lectureId
	 * @param int lectureId
	 */
	public function initWithId($id)
	{
		$zelferRoot = Yii::app()->basePath."/..";
		$this->_encodingPath 	= $zelferRoot.self::ENCODING_PATH_PREFIX.$this->chapter->course->id."/".$this->chapter_id."/".$this->id;
		$this->_streamingPath 	= $zelferRoot.self::STREAMING_PATH_PREFIX.$this->chapter->course->id."/".$this->chapter_id."/".$this->id;
		$this->_slideUrl 	= $zelferRoot.self::SLIDE_URL_PREFIX.$this->chapter->course->id."/".$this->chapter_id."/".$this->id;
		$this->_videoUrl 	= $zelferRoot.self::VIDEO_URL_PREFIX.$this->chapter->course->id."/".$this->chapter_id."/".$this->id;
		$this->step1Complete	= $this->name!="";

		$scriptRoot = Yii::app()->basePath."/scripts";
		$vhtString=exec("perl $scriptRoot/video_health_check.pl \"$this->encodingPath\"",$retval);
		$this->inputVideoHealthy	= (substr($vhtString,0,1)=='1');;
		if (!$this->inputVideoHealthy) 
		{
			$this->videoCheckError = substr($vhtString,2);
		}
		else
		{
			$this->hasWarning = (strpos($vhtString,'Warning') == true);
			if($this->hasWarning)
			{
				$elements = explode('#',$vhtString);
				$this->warningMessage = $elements[2];
			}
			else
			{
				$this->inputVideoInfo = explode('#',substr($vhtString,2));
			}
		}

		$this->canEncode = $this->inputVideoHealthy && $this->step1Complete;
		$this->isPreviouslyEncoded = file_exists("$this->streamingPath/video_complete.txt");
		$this->isEncoding = (file_exists("$this->streamingPath/video_encoding.txt") 
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
			'course' => array(self::HAS_ONE, 'Course', array('course_id' => 'id'), 'through' => 'chapter'),
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

		$criteria = new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('chapter_id',$this->chapter_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
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
	 * @return string lecture's streaming URL
	 */
	public function getStreamingUrl()
	{
		return Yii::app()->baseUrl.'/index.php?r=lecture/showEncodeResult&lectureId='.$this->id;
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
	
	/**
	 * @return string thumbnail's URL
	 */
	public function getThumbnailUrl()
	{
		// Convert streamingPath to web accessible url		
		$web_path = str_replace($_SERVER["DOCUMENT_ROOT"], "http://".$_SERVER["SERVER_NAME"], $this->streamingPath);
		$this->_thumbnailUrl = "$web_path/Snapshots/00000.jpg";
		return $this->_thumbnailUrl;
	}

	/**
	 * @return string lecture's video URL
	 * @param string player type can either be flash or silverlight
	 */
	public function getVideoObject($playerType)
	{
		// Get start and end times
		$start = '0';
		$end = 'end';
		if (file_exists("$this->streamingPath/Duration.txt")) 
		{
			$fid = fopen("$this->streamingPath/Duration.txt",'r');
			$end = trim(fgets($fid));
			fclose($fid);
		}
		if (file_exists("$this->streamingPath/Trimming.txt"))
		{
			$lines = file("$this->streamingPath/Trimming.txt");
			if (strlen(trim($lines[0])) > 0)
			{
				$start = trim($lines[0]);
			}
			if ((sizeof($lines) == 2) && (strlen(trim($lines[1])) > 0))
			{
				$end = trim($lines[1]);
			}
		}
		$format = (file_exists("$this->streamingPath/encodedVideo.mp4"))?('openclassroom'):('classx');
		$has_slides = (file_exists("$this->streamingPath/SlideManifest.txt"))?('y'):('n');

		// Convert streamingPath to web accessible url		
		$web_path = str_replace($_SERVER["DOCUMENT_ROOT"], "http://".$_SERVER["SERVER_NAME"], $this->streamingPath);

		if ($playerType === "silverlight")
		{
			$sl_param_string = "sessionPath=$web_path,start=$start,end=$end,format=$format,splash=none,deviceID=1,has_slides=$has_slides";
			$videoObject = '<object data="data:application/x-silverlight-2," type="application/x-silverlight-2" width="'.self::DEFAULT_PLAYER_WIDTH.'" height="'.self::DEFAULT_PLAYER_HEIGHT.'">
					<param name="source" value="'.Yii::app()->baseUrl.'/players/silverlight/ClassXPlayer_v2.xap"/>
					<param name="initParams" value="'.$sl_param_string.'" />
<param name="onerror" value="onSilverlightError" />
					<param name="background" value="white" />
					<param name="minRuntimeVersion" value="3.0.40624.0" />
					<param name="autoUpgrade" value="true" />
					<param name="MaxFrameRate" value="24" />
					<a href="http://go.microsoft.com/fwlink/?LinkID=124807" style="text-decoration: none;">
					<img src="http://go.microsoft.com/fwlink/?LinkId=108181" alt="Get Microsoft Silverlight" style="border-style: none"/>
					</a>
				</object>';
		}
		else if ($playerType === "flash")
		{
			$fl_param_string = "sessionPath=$web_path&start=$start&end=$end&format=$format&splash=none&deviceID=1&has_slides=$has_slides";
			$videoObject = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="960" height="540" id="ClassXPlayer_v2">
					<param name="movie" value="'.Yii::app()->baseUrl.'/players/flash/ClassXPlayer_v2.swf"/>
					<param name="flashVars" value="'.$fl_param_string.'" />
					<embed src="'.Yii::app()->baseUrl.'/players/flash/ClassXPlayer_v2.swf" width="'.self::DEFAULT_PLAYER_WIDTH.'" height="'.self::DEFAULT_PLAYER_HEIGHT.'" quality="high" allowFullScreen="true" FlashVars="'.$fl_param_string.'" pluginspage="http://www.adobe.com/go/getflashplayer">
					<param name="quality" value="high"/>
					<param name="bgcolor" value="#000000"/>
					<param name="allowScriptAccess" value="sameDomain"/>
					<param name="allowFullScreen" value="true"/>
				</object>';
		}

		return $videoObject;
	}
}
