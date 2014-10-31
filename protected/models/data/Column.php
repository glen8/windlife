<?php

/**
 * This is the model class for table "{{column}}".
 *
 * The followings are the available columns in table '{{column}}':
 * @property integer $id
 * @property string $module
 * @property integer $type
 * @property string $keyparam
 * @property integer $modelid
 * @property integer $parentid
 * @property string $arrparentid
 * @property integer $child
 * @property string $arrchildid
 * @property string $colname
 * @property string $image
 * @property string $description
 * @property string $url
 * @property string $urlparam
 * @property integer $items
 * @property string $hits
 * @property string $setting
 * @property integer $listorder
 * @property integer $display
 * @property string $letter
 * @property string $target
 * @property integer $dataway
 */
class Column extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{column}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, module, arrparentid, arrchildid, setting, url,urlparam, letter, target,description', 'safe'),
			array('url','required','message'=>'请输入链接地址','on'=>'link'),
			array('colname','required','message'=>'请输入栏目名称'),
			array('modelid','required','message'=>'请选择模型'),
			array('dataway','required','message'=>'请选择数据调用方式'),
			array('type, modelid, parentid, child, items, listorder, display, dataway', 'numerical', 'integerOnly'=>true),
			array('module, target', 'length', 'max'=>15),
			array('keyparam', 'required', 'message'=>'请输入地址访问参数', 'on'=>'base'),
			array('keyparam', 'length', 'max'=>20),
			array('keyparam', 'wl_unique','on'=>'base'),
			array('arrparentid', 'length', 'max'=>255),
			array('colname, letter', 'length', 'max'=>30),
			array('image, url', 'length', 'max'=>100),
			array('hits', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, module, type, keyparam, modelid, parentid, urlparam, arrparentid, child, arrchildid, colname, image, description, url, items, hits, setting, listorder, display, letter, target, dataway', 'safe', 'on'=>'search'),
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
			'id' => '栏目编号',
			'module' => '栏目模块',
			'type' => '栏目类型',
			'keyparam' => '访问参数',
			'modelid' => '模型编号',
			'parentid' => '上级栏目',
			'arrparentid' => '父栏目数组',
			'child' => '子栏目',
			'arrchildid' => '子栏目数组',
			'colname' => '栏目名称',
			'image' => '栏目图片',
			'description' => '栏目描述',
			'url' => '访问地址',
			'urlparam' => '访问地址参数',
			'items' => '栏目内容数据量',
			'hits' => '栏目点击次数',
			'setting' => '栏目配置',
			'listorder' => '排序',
			'display' => '是否显示',
			'letter' => '栏目拼音',
			'target' => '栏目打开方式',
			'dataway' => '栏目数据调用方式',
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
		$criteria->compare('module',$this->module,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('keyparam',$this->keyparam,true);
		$criteria->compare('modelid',$this->modelid);
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('arrparentid',$this->arrparentid,true);
		$criteria->compare('child',$this->child);
		$criteria->compare('arrchildid',$this->arrchildid,true);
		$criteria->compare('colname',$this->colname,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('urlparam',$this->urlparam,true);
		$criteria->compare('items',$this->items);
		$criteria->compare('hits',$this->hits,true);
		$criteria->compare('setting',$this->setting,true);
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('display',$this->display);
		$criteria->compare('letter',$this->letter,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('dataway',$this->dataway);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Column the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * 自定义模型keyparam验证方法
	 */	
	public function wl_unique($attribute,$params){
	    $keylist=$this->model()->findAllByAttributes(array('modelid'=>$this->modelid,'keyparam'=>$this->$attribute));
		if($this->isNewRecord&&!empty($keylist)){
			$this->addError($attribute, '地址访问参数以存在，请重新设置');
		}
		elseif(!empty($keylist)&&count($keylist)>1){
			$this->addError($attribute, '地址访问参数以存在，请重新设置');
		}
	}
	
	/**
	 * 自定义方法 取得后台菜单列表
	 */
	public function wl_getColumnOption(){
		Yii::app()->cacheManage->cacheName='ContentCache';
		$content_array=Yii::app()->cacheManage->findCache();
		$new_content_array=array();
		foreach ($content_array as $k=>$v){
			$new_content_array[$k]['id']=$k;
			$new_content_array[$k]['name']=$v['colname'];
			$new_content_array[$k]['parentid']=$v['parentid'];
		}
		$contenttree=new Tree();
		$contenttree->init($new_content_array);
		return $contenttree->get_tree_array(0);
	}
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'fieldName'=>'module',
			),
			'AttachmentRelationBehavior' => array(
				'class'=>'application.components.behaviors.AttachmentRelationBehavior',
				'attributes'=>array('image'=>false),
				'modelName'=>'Column',
			),
		));
	}
	
	public function afterSave(){		
		if($this->getIsNewRecord()){
			Yii::app()->db->createCommand()->update("{{column}}",array('arrchildid'=>$this->id),'id=:id',array('id'=>$this->id));
			if($this->parentid!=0){
				Yii::app()->db->createCommand()->update("{{column}}",array('child'=>1),'id=:id',array('id'=>$this->parentid));				
				$rows=Yii::app()->db->createCommand()->select('arrparentid')->from('{{column}}')->where('id=:id',array('id'=>$this->parentid))->query()->readAll();
				Yii::app()->db->createCommand()->update("{{column}}",array('arrparentid'=>$rows[0]['arrparentid'].','.$this->parentid),'id=:id',array('id'=>$this->id));
				$parentid_array=explode(',', $rows[0]['arrparentid'].','.$this->parentid);
				foreach ($parentid_array as $v){
					if($v!=0){
						Yii::app()->db->createCommand()->update("{{column}}",array('arrchildid'=>new CDbExpression("concat(arrchildid,',{$this->id}')")),'id=:id',array('id'=>$v));
					}
				}				
			}
		}
		parent::afterSave();
	}
	
	public function afterDelete(){
		if($this->arrparentid!=""&&$this->arrparentid!='0'){
			$parentid_array=explode(',', $this->arrparentid);
			foreach ($parentid_array as $v){
				if($v!=0){
					$rows=Yii::app()->db->createCommand()->select('arrchildid')->from('{{column}}')->where('id=:id',array('id'=>$v))->query()->readAll();
					if($rows[0]['arrchildid']!=''&&$rows[0]['arrchildid']!='0'){
						$new_arrchildid=substr($rows[0]['arrchildid'], 0,strpos($rows[0]['arrchildid'],','.$this->id));
						Yii::app()->db->createCommand()->update("{{column}}",array('arrchildid'=>$new_arrchildid),'id=:id',array('id'=>$v));
					    if($new_arrchildid==$v){
					    	Yii::app()->db->createCommand()->update("{{column}}",array('child'=>0),'id=:id',array('id'=>$v));
					    }
					}
				}
			}
		}
		//单页面删除栏目的时候一并删除单页面记录
		if($this->type==1&&$this->modelid>0){
			Yii::app()->cacheManage->cacheName='ModelCache';
			$model_cache=Yii::app()->cacheManage->findCache();
			$model_object=$model_cache[$this->modelid];
			if($model_object['data_num']==0){
				$object=$model_cache[$this->modelid]['object'];
				$data_only=BaseModel::model($object)->findByAttributes(array('column_id'=>$this->id));
				if($data_only!==null){$data_only->delete();}
			}			
		}
		parent::afterDelete();
	}	
}
