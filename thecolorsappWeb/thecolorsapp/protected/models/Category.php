<?php

/**
 * This is the model class for table "Category".
 *
 * The followings are the available columns in table 'Category':
 * @property string $cat_name
 * @property integer $cat_user_num
 * @property string $cat_points
 *
 * The followings are the available model relations:
 * @property Card[] $cards
 * @property RankCalc $rankCalc
 * @property Ranks[] $ranks
 * @property User[] $users
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
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
		return 'Category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cat_name', 'required'),
			array('cat_user_num', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>100),
			array('cat_points', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cat_name, cat_user_num, cat_points', 'safe', 'on'=>'search'),
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
			'cards' => array(self::HAS_MANY, 'Card', 'cat_name'),
			'rankCalc' => array(self::HAS_ONE, 'RankCalc', 'cat_name'),
			'ranks' => array(self::HAS_MANY, 'Ranks', 'cat_name'),
			'users' => array(self::MANY_MANY, 'User', 'User_Category(cat_name, fb_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cat_name' => 'Cat Name',
			'cat_user_num' => 'Cat User Num',
			'cat_points' => 'Cat Points',
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

		$criteria->compare('cat_name',$this->cat_name,true);
		$criteria->compare('cat_user_num',$this->cat_user_num);
		$criteria->compare('cat_points',$this->cat_points,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}