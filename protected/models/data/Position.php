<?php

/**
 * This is the model class for table "{{position}}".
 *
 * The followings are the available columns in table '{{position}}':
 * @property integer $id
 * @property string $key_name
 * @property string $description
 * @property integer $type
 */
class Position extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{position}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('key_name', 'required','message'=>'请输入'),
			array('description', 'required','message'=>'请输入'),
			array('key_name', 'unique', 'criteria' => array('condition' => "key_name<>'{$this->key_name}'"),'message'=>'不能重复'),				
			array('type', 'numerical', 'integerOnly'=>true),
			array('key_name', 'length', 'max'=>50),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, key_name, description, type', 'safe', 'on'=>'search'),
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
			'id' => '编号',
			'key_name' => '位置引用key',
			'description' => '位置描述',
			'type' => '内容/广告位置',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('key_name',$this->key_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Position the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'PositionCache',
			),
		));
	}
}
