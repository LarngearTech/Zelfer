<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $id
 * @property string $name
 * @property string $short_description
 * @property string $long_description
 * @property integer $category_id
 */
class Course extends CActiveRecord
{
	const STATUS_OPEN = 1;
	const STATUS_CLOSE = 2;
	const STATUS_RUNNING = 3;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Course the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Post-processing after the record is instantiated by a find method.
	 * Assign thumbnail URL for a course.
	 */
	protected function afterFind()
	{
		parent::afterFind();
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category_id', 'required'),
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('name, short_description', 'length', 'max'=>255),
			array('long_description', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, category_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'contents' => array(self::HAS_MANY, 'Content', 'course_id'),
			'instructors' => array(self::MANY_MANY, 'User', 'instructor_course(course_id, user_id)'),
			//'instructor_courses' => array(self::HAS_MANY, 'instructor_course', 'course_id'),
			'students' => array(self::MANY_MANY, 'User', 'student_course(course_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => Yii::t('site', 'Course Name'),
			'short_description' => Yii::t('site', 'Description in one sentence'),
			'long_description' => Yii::t('site', 'Course summary'),
			'category_id' => Yii::t('site', 'Category'),
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
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('long_description',$this->long_description,true);
		$criteria->compare('category_id',$this->category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Default scope return publish and unpublish course
	 */
	public function defaultScope()
	{
		return array(
			'condition' => 'status=0 or status=1',
		);
	}


	/**
	 * Return only records that match specified status.
	 * @param string $status course status can be 'draft' or 'publish'.
	 */
	public function status($status)
	{
		$status_code = $status==='draft'?0:1;
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'status=:status',
			'params' => array(
				':status' => $status_code,
			),
		));
		return $this;
	}

	/**
	 * Return only records that match specified category id.
	 * @param integer $categoryId course's category id.
	 */
	public function category($categoryId)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'category_id=:categoryId',
			'params' => array(
				':categoryId' => $categoryId,
			),
		));
		return $this;
	}

	
	/**
	 * Publish course.
	 * @return string error message if publish failed.
	 */
	public function publish()
	{
		$this->status = 1;
		$this->save();
	}


	/**
	 * Unpublish course
	 * @return string error message if unpublish failed.
	 */
	public function unpublish()
	{
		$this->status = 0;
		$this->save();
	}


	/**
	 * Return All record
	 * @return array 
	 */
	public function getCourseInstructors()
	{
		$sql = 'SELECT instructor_course.instructor_career, instructor_course.instructor_description, user.fullname, user.id
			FROM instructor_course
			INNER JOIN user ON user.id = instructor_course.user_id
			WHERE instructor_course.course_id = '.$this->id;
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		return $rows;
	}

	/**
	 * Check whether $userId is already taken the course.
	 * @return boolean true if $userId is in class, else, false.
	 */
	public function hasStudent($userId)
	{
		$sql = 'SELECT 1 FROM student_course 
			WHERE course_id='.$this->id.'
			AND user_id='.$userId;
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($result) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Return path to resource of course specified by $courseId
	 * @param integer the ID of course
	 * @return string resource path
	 */
	public function getResourcePath()
	{
		return Yii::getPathOfAlias('webroot').'/course/'. $this->id;
	}

	/*
	 * Get an in-class URL for a subscriber.
	 * @return string in-class URL
	 */
	public function getInClassUrl()
	{
		if (self::isStarted())
		{
			return 'index.php?r=course/inclass&id='.$this->id;
		}
		else
		{
			return 'index.php?r=course/view&id='.$this->id;
		}
	}

	/**
	 * Check whether the course has started or not 
	 * @return boolean true if course has started, else, false
	 */
	public function isStarted()
	{
		$sql = 'SELECT * FROM course_open WHERE course_id='.$this->id;
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		if (count($rows) > 0)
		{
			if ($rows[0]['open_status_id'] == self::STATUS_RUNNING)
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Return a string of instructors in a shorten form
	 * @return string instructors
	 */
	public function getCourseInstructorsShortString()
	{
		$insStr = '';
		if ($this->instructors !== null)
		{
			$insStr = $this->instructors[0]->fullname; 
			$numIns = count($this->instructors);
			if ($numIns == 2)
			{
				$insStr .= ' '.Yii::t('site', 'and').' '.$this->instructors[1]->fullname;
			}
			else if ($numIns > 2)
			{
				$insStr .= ' '.Yii::t('site', 'and {numIns} others.', array(
					'{numIns}' => $numIns
				));
			}
		}
		return $insStr;
	}

	public function deleteIntroVideo()
	{
		if (!empty($this->intro_url))
		{
			$introVideoPath = ResourcePath::getIntroVideoBasePath().$this->intro_url;
			if (file_exists($introVideoPath))
			{
				shell_exec('rm -rf '.$introVideoPath);
			}
		}
	}


	public function deleteThumbnail()
	{
		if (!empty($this->thumbnail_url))
		{
			$thumbnailPath = ResourcePath::getCourseThumbnailBasePath().PHPHelper::getFileFullName($this->thumbnail_url);
			if (file_exists($thumbnailPath))
			{
				unlink($thumbnailPath);
			}
		}
	}
}
