<?php

/**
 * This is the model class for table "{{model_param}}".
 *
 * The followings are the available columns in table '{{model_param}}':
 * @property integer $id
 * @property integer $model_id
 * @property string $name
 * @property string $key
 * @property string $default_value
 * @property string $type
 * @property string $value_items
 * @property string $model_field
 * @property integer $position
 * @property integer $listorder
 */
class ModelParam extends AdminBaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{model_param}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_id, name, key, default_value, type', 'required'),
			array('model_id, position, listorder', 'numerical', 'integerOnly'=>true),
			array('name, type, model_field', 'length', 'max'=>20),
			array('key', 'length', 'max'=>30),
			array('default_value', 'length', 'max'=>100),
			array('value_items', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_id, name, key, default_value, type, value_items, model_field, position, listorder', 'safe', 'on'=>'search'),
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
			'id' => '自动编号',
			'model_id' => '模型编号',
			'name' => '参数名称',
			'key' => '参数引用key',
			'default_value' => '默认值',
			'type' => '参数类型',
			'value_items' => '参数值集合',
			'model_field' => '对应模型字段名称',
			'position' => '参数位置(前台/后台)',
			'listorder' => '排序',
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
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('default_value',$this->default_value,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('value_items',$this->value_items,true);
		$criteria->compare('model_field',$this->model_field,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('listorder',$this->listorder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelParam the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
