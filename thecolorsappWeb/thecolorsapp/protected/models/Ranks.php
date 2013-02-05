<?php

/**
 * This is the model class for table "Ranks".
 *
 * The followings are the available columns in table 'Ranks':
 * @property integer $rank_id
 * @property string $cat_name
 * @property string $rank_name
 * @property integer $rank_priority
 *
 * The followings are the available model relations:
 * @property Category $catName
 */
class Ranks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ranks the static model class
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
		return 'Ranks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rank_priority', 'numerical', 'integerOnly'=>true),
			array('cat_name', 'length', 'max'=>100),
			array('rank_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rank_id, cat_name, rank_name, rank_priority', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rank_id' => 'Rank',
			'cat_name' => 'Cat Name',
			'rank_name' => 'Rank Name',
			'rank_priority' => 'Rank Priority',
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

		$criteria->compare('rank_id',$this->rank_id);
		$criteria->compare('cat_name',$this->cat_name,true);
		$criteria->compare('rank_name',$this->rank_name,true);
		$criteria->compare('rank_priority',$this->rank_priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}