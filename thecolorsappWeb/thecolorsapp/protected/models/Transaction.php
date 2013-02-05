<?php

/**
 * This is the model class for table "Transaction".
 *
 * The followings are the available columns in table 'Transaction':
 * @property integer $trans_id
 * @property string $fb_id
 * @property integer $card_id
 * @property string $dateTime
 * @property string $trans_type
 *
 * The followings are the available model relations:
 * @property User $fb
 * @property Card $card
 */
class Transaction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Transaction the static model class
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
		return 'Transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('card_id', 'numerical', 'integerOnly'=>true),
			array('fb_id', 'length', 'max'=>200),
			array('trans_type', 'length', 'max'=>100),
			array('dateTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('trans_id, fb_id, card_id, dateTime, trans_type', 'safe', 'on'=>'search'),
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
			'fb' => array(self::BELONGS_TO, 'User', 'fb_id'),
			'card' => array(self::BELONGS_TO, 'Card', 'card_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'trans_id' => 'Trans',
			'fb_id' => 'Fb',
			'card_id' => 'Card',
			'dateTime' => 'Date Time',
			'trans_type' => 'Trans Type',
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

		$criteria->compare('trans_id',$this->trans_id);
		$criteria->compare('fb_id',$this->fb_id,true);
		$criteria->compare('card_id',$this->card_id);
		$criteria->compare('dateTime',$this->dateTime,true);
		$criteria->compare('trans_type',$this->trans_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}