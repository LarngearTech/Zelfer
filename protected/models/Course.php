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
	const THUMBNAIL_URL_PREFIX = '/asset/thumbnail/';

	protected $thumbnailUrl;

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
		$this->thumbnailUrl = self::THUMBNAIL_URL_PREFIX.$this->id;
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
			array('name, short_description, long_description, category_id', 'required'),
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
			'chapters' => array(self::HAS_MANY, 'Chapter', 'course_id'),
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
			'name' => 'Name',
			'short_description' => 'Description in one sentence',
			'long_description' => 'Course summary',
			'category_id' => 'Category',
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
	 * @return string course's thumbnail URL
	 */
	public function getThumbnailUrl()
	{
		return $this->thumbnailUrl;
	}

	/**
	 * Return All record
	 * @return array 
	 */
	public function getCourseInstructors()
	{
		$sql = 'SELECT instructor_course.instructor_career, instructor_course.instructor_description, user.fullname
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
}
