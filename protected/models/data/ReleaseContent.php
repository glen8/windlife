<?php

/**
 * This is the model class for table "{{release_content}}".
 *
 * The followings are the available columns in table '{{release_content}}':
 * @property integer $id
 * @property integer $release_id
 * @property integer $model_id
 * @property integer $column_id
 * @property integer $data_id
 * @property string $title
 * @property string $description
 * @property string $thumb
 * @property string $url
 * @property integer $listorder
 * @property integer $status
 * @property string $ctime
 */
class ReleaseContent extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{release_content}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('release_id, model_id, column_id, data_id, title, description, url', 'required'),
			array('release_id, model_id, column_id, data_id, listorder, status', 'numerical', 'integerOnly'=>true),
			array('title, thumb, url', 'length', 'max'=>100),
			array('description', 'length', 'max'=>255),
			array('ctime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, release_id, model_id, column_id, data_id, title, description, thumb, url, listorder, status, ctime', 'safe', 'on'=>'search'),
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
			'release_id' => '所属内容发布',
			'model_id' => 'Model',
			'column_id' => '所属栏目',
			'data_id' => 'Data',
			'title' => '标题',
			'description' => '描述',
			'thumb' => '缩略图',
			'url' => '地址',
			'listorder' => '排序',
			'status' => '状态',
			'ctime' => '时间',
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
		$criteria->compare('release_id',$this->release_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('column_id',$this->column_id);
		$criteria->compare('data_id',$this->data_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('ctime',$this->ctime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ReleaseContent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors(){
		return array_merge(parent::behaviors(),array(
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'ReleaseCache',
			),
		));
	}
	
	public function afterSave(){
		if($this->getIsNewRecord()){
			Release::model()->updateCounters(array('num'=>1),'id='.$this->release_id);
		}
		return parent::afterSave();
	}
	
	public function afterDelete(){
		Release::model()->updateCounters(array('num'=>-1),'id='.$this->release_id);
		return parent::afterDelete();
	}
}
