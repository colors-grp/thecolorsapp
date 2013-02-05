<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property string $fb_id
 * @property integer $purch_points
 * @property integer $trading_points
 * @property string $total_points
 * @property string $theme_name
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property Transaction[] $transactions
 * @property Card[] $cards
 * @property Category[] $categories
 */
class User extends CActiveRecord
{
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
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fb_id', 'required'),
			array('purch_points, trading_points, type', 'numerical', 'integerOnly'=>true),
			array('fb_id', 'length', 'max'=>200),
			array('total_points', 'length', 'max'=>20),
			array('theme_name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fb_id, purch_points, trading_points, total_points, theme_name, type', 'safe', 'on'=>'search'),
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
			'transactions' => array(self::HAS_MANY, 'Transaction', 'fb_id'),
			'cards' => array(self::MANY_MANY, 'Card', 'User_Card(fb_id, card_id)'),
			'categories' => array(self::MANY_MANY, 'Category', 'User_Category(fb_id, cat_name)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fb_id' => 'Fb',
			'purch_points' => 'Purch Points',
			'trading_points' => 'Trading Points',
			'total_points' => 'Total Points',
			'theme_name' => 'Theme Name',
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

		$criteria=new CDbCriteria;

		$criteria->compare('fb_id',$this->fb_id,true);
		$criteria->compare('purch_points',$this->purch_points);
		$criteria->compare('trading_points',$this->trading_points);
		$criteria->compare('total_points',$this->total_points,true);
		$criteria->compare('theme_name',$this->theme_name,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}