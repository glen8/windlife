<?php

/**
 * This is the model class for table "{{urlrule}}".
 *
 * The followings are the available columns in table '{{urlrule}}':
 * @property integer $id
 * @property string $name
 * @property string $module
 * @property string $rule
 * @property string $rule_url
 * @property string $page_rule
 * @property string $page_rule_url
 * @property integer $listorder
 */
class Urlrule extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{urlrule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required', 'message'=>'规则名称为必填项，请输入'),
			array('module', 'required', 'message'=>'请选择所属模块'),
			array('rule_url', 'required', 'message'=>'规则对应地址为必填项，请输入'),
			array('name, rule, rule_url', 'length', 'max'=>50),
			array('module', 'length', 'max'=>20),
			array('page_rule, page_rule_url', 'length', 'max'=>60),
			array('listorder','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, module, rule, rule_url, page_rule, page_rule_url,listorder', 'safe', 'on'=>'search'),
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
			'name' => '规则名称',
			'module' => '所属模块',
			'rule' => '规则',
			'rule_url' => '规则对应地址',
			'page_rule' => '分页规则',
			'page_rule_url' => '分页规则对应地址',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('rule',$this->rule,true);
		$criteria->compare('rule_url',$this->rule_url,true);
		$criteria->compare('page_rule',$this->page_rule,true);
		$criteria->compare('page_rule_url',$this->page_rule_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Urlrule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'UrlruleCache',
			),
		));
	}
	
}
