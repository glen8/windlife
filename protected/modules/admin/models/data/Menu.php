<?php

/**
 * This is the model class for table "{{_menu}}".
 *
 * The followings are the available columns in table '{{_menu}}':
 * @property integer $id
 * @property string $name
 * @property integer $parentid
 * @property string $m
 * @property string $c
 * @property string $a
 * @property string $data
 * @property integer $listorder
 * @property string $display
 * @property string $size
 */
class Menu extends AdminBaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menu the static model class
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
		return '{{menu}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent_id, listorder', 'numerical', 'integerOnly'=>true),
			array('name','required','message'=>'请填写菜单名称'),
			array('name', 'length', 'max'=>60),
			array('m, c, a', 'length', 'max'=>20),
			array('m','required','message'=>'请填写模块名'),
			array('c','required','message'=>'请填写控制器'),
			array('a','required','message'=>'请填写方法名'),
			array('data', 'length', 'max'=>100),
			array('display', 'length', 'max'=>1),
			array('size', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, parent_id, m, c, a, data, listorder, display, size', 'safe', 'on'=>'search'),
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
			'parent'=>array(self::BELONGS_TO, 'Menu', 'parent_id'),
			'childrens'=>array(self::HAS_MANY, 'Menu', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => '菜单名称',
			'parent_id' => '上级菜单',
			'm' => '模块名',
			'c' => '控制器',
			'a' => '方法名',
			'data' => '附加参数',
			'listorder' => '排序',
			'display' => '是否显示',
			'size' => '显示尺寸'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('m',$this->m,true);
		$criteria->compare('c',$this->c,true);
		$criteria->compare('a',$this->a,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('display',$this->display,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	/**
	 * 自定义方法 取得后台菜单列表
	 */
	public function wl_getMenuOption(){
		Yii::app()->cacheManage->cacheName='MenuCache';
		$menu_array=Yii::app()->cacheManage->findCache();
        $menutree=new Tree();
        $menutree->init($menu_array);
        return $menutree->get_tree_array(0);
	}
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'MenuCache',	
		    ),
			'SynchronousAccessBehavior'=>array(
				'class'=>'application.components.behaviors.SynchronousAccessBehavior'
			)
		));
	}	

}