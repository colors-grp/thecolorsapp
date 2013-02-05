<?php

/**
 * This is the model class for table "Buy".
 *
 * The followings are the available columns in table 'Buy':
 * @property integer $buy_id
 * @property integer $buy_points
 * @property double $buy_price
 */
class Buy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Buy the static model class
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
		return 'Buy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('buy_points, buy_price', 'required'),
			array('buy_points', 'numerical', 'integerOnly'=>true),
			array('buy_price', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('buy_id, buy_points, buy_price', 'safe', 'on'=>'search'),
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
			'buy_id' => 'Buy',
			'buy_points' => 'Buy Points',
			'buy_price' => 'Buy Price',
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

		$criteria->compare('buy_id',$this->buy_id);
		$criteria->compare('buy_points',$this->buy_points);
		$criteria->compare('buy_price',$this->buy_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}