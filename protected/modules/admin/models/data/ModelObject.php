<?php

/**
 * This is the model class for table "{{model_object}}".
 *
 * The followings are the available columns in table '{{model_object}}':
 * @property integer $id
 * @property string $name
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $data
 * @property string $object
 * @property integer $items
 * @property string $m_module
 * @property string $m_controller
 * @property string $m_action
 * @property string $m_data
 * @property integer $data_num
 */
class ModelObject extends AdminBaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{model_object}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, controller, action, object, m_controller, m_action', 'required', 'message'=>'不能为空，请填写'),
			array('items, data_num', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('module, controller, action, object, m_module, m_controller, m_action', 'length', 'max'=>20),
			array('data, m_data', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, module, controller, action, data, object, items, m_module, m_controller, m_action, m_data, data_num', 'safe', 'on'=>'search'),
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
			'name' => '模型名称',
			'module' => '模块',
			'controller' => '控制器',
			'action' => '方法',
			'data' => '参数',
			'object' => '模型对象',
			'items' => '模型数据量',
			'm_module' => '管理地址模块',
			'm_controller' => '管理地址控制器',
			'm_action' => '管理地址方法',
			'm_data' => '管理地址参数',
			'data_num' => '数据条目',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('object',$this->object,true);
		$criteria->compare('items',$this->items);
		$criteria->compare('m_module',$this->m_module,true);
		$criteria->compare('m_controller',$this->m_controller,true);
		$criteria->compare('m_action',$this->m_action,true);
		$criteria->compare('m_data',$this->m_data,true);
		$criteria->compare('data_num',$this->data_num);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelObject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * 自定义方法 取得模型数据
	 */
	public function wl_getModels(){
		Yii::app()->cacheManage->cacheName='ModelCache';
		return Yii::app()->cacheManage->findCache();
	}
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'ModelCache',
			),
		));
	}
	
}
