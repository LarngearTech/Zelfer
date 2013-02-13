<?php

/**
 * This is the model class for table "user_group".
 *
 * The followings are the available columns in table 'user_group':
 * @property integer $id
 * @property string $name
 * @property integer $order
 * @property integer $parent_id
 * @property integer $type
 */
class UserGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserGroup the static model class
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
		return 'user_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, order, parent_id, type', 'required'),
			array('order, parent_id, type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, order, parent_id, type', 'safe', 'on'=>'search'),
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
			'order' => 'Order',
			'parent_id' => 'Parent',
			'type' => 'Type',
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
		$criteria->compare('order',$this->order);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function isGroup()
	{
		if ($this->type == Yii::app()->params['group'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function isSubgroup()
	{
		if ($this->type == Yii::app()->params['subgroup'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Get all users in the group.
	 */ 
	public function getUsers()
	{
		$users = Yii::app()->db->createCommand()
			->select('id, fullname')
			->from('user u')
			->join('user_in_group uig', 'uig.uid=u.id')
			->where('uig.gid=:id', array(':id' => $this->id))
			->queryAll();
		return $users;
	}

	public function getNotInGroupUsers()
	{
		$inGroupUsers = $this->users;
		$inGroupUserIds = array();
		foreach ($inGroupUsers as $user)
		{
			$inGroupUserIds[] = $user['id'];
		}
		$notInGroupUsers = Yii::app()->db->createCommand()
			->select('id, fullname')
			->from('user u')
			->where(array('not in', 'id', $inGroupUserIds))
			->queryAll();
		return $notInGroupUsers;

	}
}