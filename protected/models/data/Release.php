<?php

/**
 * This is the model class for table "{{release}}".
 *
 * The followings are the available columns in table '{{release}}':
 * @property integer $id
 * @property string $key_name
 * @property string $title
 * @property integer $max_num
 * @property integer $num
 * @property integer $model_id
 * @property integer $first_title_length
 * @property integer $first_desc_length
 * @property integer $img_title_length
 * @property integer $img_desc_length
 * @property string $img_size
 * @property integer $other_title_length
 * @property integer $other_desc_length
 */
class Release extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{release}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('key_name, title', 'required'),
			array('key_name', 'unique', 'criteria' => array('condition' => "key_name<>'{$this->key_name}'"),'message'=>'不能重复'),		
			array('num, max_num, model_id, first_title_length, first_desc_length, img_title_length, img_desc_length, other_title_length, other_desc_length', 'numerical', 'integerOnly'=>true),
			array('key_name', 'length', 'max'=>50),
			array('title', 'length', 'max'=>100),
			array('img_size', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, key_name, title, num, num_max, model_id, first_title_length, first_desc_length, img_title_length, img_desc_length, img_size, other_title_length, other_desc_length', 'safe', 'on'=>'search'),
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
			'key_name' => '位置',
			'title' => '内容块名称',
			'max_num' => '最大数量',
			'num' => '数据量',
			'model_id' => '所属模型',
			'first_title_length' => '头条标题长度',
			'first_desc_length' => '头条描述长途',
			'img_title_length' => '图片内容标题长度',
			'img_desc_length' => '图片内容描述长度',
			'img_size' => '图片大小',
			'other_title_length' => '普通标题长途',
			'other_desc_length' => '普通描述长途',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('num',$this->num);
		$criteria->compare('max_num',$this->max_num);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('first_title_length',$this->first_title_length);
		$criteria->compare('first_desc_length',$this->first_desc_length);
		$criteria->compare('img_title_length',$this->img_title_length);
		$criteria->compare('img_desc_length',$this->img_desc_length);
		$criteria->compare('img_size',$this->img_size,true);
		$criteria->compare('other_title_length',$this->other_title_length);
		$criteria->compare('other_desc_length',$this->other_desc_length);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Release the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
