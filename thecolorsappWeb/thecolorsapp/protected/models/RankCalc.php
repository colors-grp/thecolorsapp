<?php

/**
 * This is the model class for table "Rank_Calc".
 *
 * The followings are the available columns in table 'Rank_Calc':
 * @property string $cat_name
 * @property string $equation
 *
 * The followings are the available model relations:
 * @property Category $catName
 */
class RankCalc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RankCalc the static model class
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
		return 'Rank_Calc';
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
			array('cat_name', 'length', 'max'=>100),
			array('equation', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cat_name, equation', 'safe', 'on'=>'search'),
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
			'cat_name' => 'Cat Name',
			'equation' => 'Equation',
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
		$criteria->compare('equation',$this->equation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}