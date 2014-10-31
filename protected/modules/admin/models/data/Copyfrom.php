<?php

/**
 * This is the model class for table "{{copyfrom}}".
 *
 * The followings are the available columns in table '{{copyfrom}}':
 * @property integer $id
 * @property string $sitename
 * @property string $siteurl
 * @property string $thumb
 * @property integer $listorder
 * @property integer $is_default
 */
class Copyfrom extends AdminBaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{copyfrom}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sitename', 'required', 'message'=>'请输入来源名称'),
			array('siteurl', 'required', 'message'=>'请输入来源链接'),
			array('siteurl', 'url', 'message'=>'请输入http://格式正确的链接地址'),
			array('listorder, is_default', 'numerical', 'integerOnly'=>true),
			array('sitename', 'length', 'max'=>30),
			array('siteurl, thumb', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sitename, siteurl, thumb, listorder, is_default', 'safe', 'on'=>'search'),
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
			'sitename' => '来源名称',
			'siteurl' => '来源链接',
			'thumb' => '来源logo',
			'listorder' => '排序',
			'is_default' => '默认来源',
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
		$criteria->compare('sitename',$this->sitename,true);
		$criteria->compare('siteurl',$this->siteurl,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('is_default',$this->is_default);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Copyfrom the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'CopyfromCache',
			),
		));
	}
	
	public function beforeSave(){
		if($this->is_default===1){
		    $this->model()->updateAll(array('is_default'=>'0'));
		}
		return parent::beforeSave();
	}
}
