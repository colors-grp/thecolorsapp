<?php

/**
 * This is the model class for table "Card".
 *
 * The followings are the available columns in table 'Card':
 * @property integer $card_id
 * @property string $cat_name
 * @property integer $card_points
 *
 * The followings are the available model relations:
 * @property Category $catName
 * @property Transaction[] $transactions
 * @property User[] $users
 */
class Card extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Card the static model class
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
		return 'Card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('card_id', 'required'),
			array('card_id, card_points', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('card_id, cat_name, card_points', 'safe', 'on'=>'search'),
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
			'catName' => array(self::BELONGS_TO, 'Category', 'cat_name'),
			'transactions' => array(self::HAS_MANY, 'Transaction', 'card_id'),
			'users' => array(self::MANY_MANY, 'User', 'User_Card(card_id, fb_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'card_id' => 'Card',
			'cat_name' => 'Cat Name',
			'card_points' => 'Card Points',
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

		$criteria->compare('card_id',$this->card_id);
		$criteria->compare('cat_name',$this->cat_name,true);
		$criteria->compare('card_points',$this->card_points);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}