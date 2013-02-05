<?php

/**
 * This is the model class for table "User_Category".
 *
 * The followings are the available columns in table 'User_Category':
 * @property string $fb_id
 * @property string $cat_name
 * @property string $user_cat_score
 */
class UserCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserCategory the static model class
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
		return 'User_Category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fb_id, cat_name', 'required'),
			array('fb_id', 'length', 'max'=>200),
			array('cat_name', 'length', 'max'=>100),
			array('user_cat_score', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fb_id, cat_name, user_cat_score', 'safe', 'on'=>'search'),
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
			'fb_id' => 'Fb',
			'cat_name' => 'Cat Name',
			'user_cat_score' => 'User Cat Score',
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

		$criteria->compare('fb_id',$this->fb_id,true);
		$criteria->compare('cat_name',$this->cat_name,true);
		$criteria->compare('user_cat_score',$this->user_cat_score,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}