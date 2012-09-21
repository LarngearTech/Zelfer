<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property integer $role
 * @property boolean $status
 */
class User extends CActiveRecord
{
	const USER_RESOURCE_PREFIX = '/user/';
	const DEFAULT_USER_PROFILE_URL = 'http://placehold.it/120x140';

	public $repeat_password;

	protected $_profileImageUrl;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, repeat_password, fullname, role', 'required'),
			array('email, password, repeat_password, fullname', 'length', 'max'=>128),
			array('password', 'compare', 'compareAttribute' => 'repeat_password'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, fullname, role, active', 'safe', 'on'=>'search'),
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
			'created_courses' => array(self::MANY_MANY, 'Course', 'instructor_course(user_id, course_id)'),
			'taken_courses' => array(self::MANY_MANY, 'Course', 'student_course(user_id, course_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => Yii::t('site', 'Email'),
			'password' => Yii::t('site', 'Password'),
			'repeat_password' => Yii::t('site', 'Repeat Password'),
			'fullname' => Yii::t('site', 'Full Name'),
			'role' => Yii::t('site', 'Role'),
			'active' => Yii::t('site', 'Active'),
		);
	}


	/**
	 * @param CDbCriteria criteria search criteria
	 * @param integer pagination number of items per page
	 * @return CActiveDataProvider data provider based on specified search criteria and pagination
	 **/
	public function getDataProvider($criteria=null, $pagination=null)
	{
 		if ((is_array ($criteria)) || ($criteria instanceof CDbCriteria) )
		           $this->getDbCriteria()->mergeWith($criteria);
        	return new CActiveDataProvider(__CLASS__, array(
        			                'criteria'=>$this->getDbCriteria(),
        			                'pagination' => $pagination
        					));		
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		// Hash password
		if (!empty($this->password) && $this->password == $this->repeat_password)
		{
			$ph = new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);
			$this->password = $ph->HashPassword($this->password);
		}

		// Default role is '2' (normal user).
		if (empty($this->role))
		{
			$this->role = 2;
		}

		// Default status is '1' (active).
		if (empty($this->status))
		{
			$this->status = 1;
		}

		return parent::beforeSave();
	}

	 /**
         * Return path to resource of user
         * @return string resource path
         */
        public function getResourcePath()
        {
                return Yii::getPathOfAlias('webroot').self::USER_RESOURCE_PREFIX.$this->id;
        }

	/**
	 * Get URL of a user.
	 * Return template image URL if image URL is not found
	 * @return string profile image URL
	 */
	public function getProfileImageUrl()
	{
		$path = $this->getResourcePath();
		if (file_exists("$path/profile.jpg"))
		{
			$this->_profileImageUrl = Yii::app()->baseUrl.self::USER_RESOURCE_PREFIX.$this->id."/profile.jpg";
			return $this->_profileImageUrl;
		}
		else
		{
			return self::DEFAULT_USER_PROFILE_URL;
		}
	}

	/**
	 * Get ID of all registered courses.
	 * Return array of registered courses' Ids
	 * @return array registered courses' ids
	 */
	public function getRegisteredCourses()
	{
		$sql = 'SELECT course.id, course.name 
				FROM student_course
				INNER JOIN course ON course.id = student_course.course_id
				WHERE student_course.user_id = '.$this->id;
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		return $rows;
	}
}
