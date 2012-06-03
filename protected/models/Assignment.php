<?php

/**
 * This is the model class for table "assignment".
 *
 * The followings are the available columns in table 'assignment':
 * @property integer $id
 * @property string $name
 * @property integer $course_id
 * @property integer $type
 * @property string $release_date
 * @property string $full_credit_expiry_date
 * @property string $reduced_credit_expiry_date
 * @property integer $reduced_credit_percentage
 */
class Assignment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Assignment the static model class
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
		return 'assignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, course_id, type, release_date, full_credit_expiry_date, reduced_credit_expiry_date, reduced_credit_percentage', 'required'),
			array('course_id, type, reduced_credit_percentage', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, course_id, type, release_date, full_credit_expiry_date, reduced_credit_expiry_date, reduced_credit_percentage', 'safe', 'on'=>'search'),
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
			'course_id' => 'Course',
			'type' => 'Type',
			'release_date' => 'Release Date',
			'full_credit_expiry_date' => 'Full Credit Expiry Date',
			'reduced_credit_expiry_date' => 'Reduced Credit Expiry Date',
			'reduced_credit_percentage' => 'Reduced Credit Percentage',
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
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('release_date',$this->release_date,true);
		$criteria->compare('full_credit_expiry_date',$this->full_credit_expiry_date,true);
		$criteria->compare('reduced_credit_expiry_date',$this->reduced_credit_expiry_date,true);
		$criteria->compare('reduced_credit_percentage',$this->reduced_credit_percentage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}