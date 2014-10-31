<?php

/**
 * This is the model class for table "{{badword}}".
 *
 * The followings are the available columns in table '{{badword}}':
 * @property integer $id
 * @property string $badword
 * @property integer $level
 * @property string $replaceword
 * @property string $lastusetime
 */
class Badword extends AdminBaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{badword}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('badword', 'required', 'message'=>'请输入敏感词'),
			array('badword', 'unique', 'criteria' => array('condition' => "badword<>'{$this->badword}'"),'message'=>'敏感词已存在'),		
			array('level', 'numerical', 'integerOnly'=>true),
			array('badword, replaceword', 'length', 'max'=>20),
			array('lastusetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, badword, level, replaceword, lastusetime', 'safe', 'on'=>'search'),
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
			'badword' => '敏感词',
			'level' => '敏感等级',
			'replaceword' => '替换词',
			'lastusetime' => '创建时间',
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
		$criteria->compare('badword',$this->badword,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('replaceword',$this->replaceword,true);
		$criteria->compare('lastusetime',$this->lastusetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Badword the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'BadwordCache',
			),
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'lastusetime',
				'updateAttribute' => null,
			)
		));
	}
}
