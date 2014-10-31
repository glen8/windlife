<?php

/**
 * This is the model class for table "{{advert_item}}".
 *
 * The followings are the available columns in table '{{advert_item}}':
 * @property integer $id
 * @property integer $ad_id
 * @property string $title
 * @property integer $hits
 * @property string $thumb
 * @property string $file_url
 * @property string $link_url
 * @property string $target
 * @property string $created
 * @property integer $listorder
 */
class AdvertItem extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{advert_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ad_id, title, file_url, link_url', 'required'),
			array('ad_id, hits, listorder', 'numerical', 'integerOnly'=>true),
			array('title, thumb, file_url, link_url', 'length', 'max'=>100),
			array('created,target', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ad_id, title, hits, thumb, file_url, link_url, created, listorder', 'safe', 'on'=>'search'),
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
			'advert'=>array(self::BELONGS_TO, 'Advert', 'ad_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '编号',
			'ad_id' => '所属广告位',
			'title' => '标题',
			'hits' => '点击次数',
			'thumb' => '缩略图',
			'file_url' => '广告文件',
			'link_url' => '链接地址',
			'target' => '打开方式',
			'created' => 'Created',
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
		$criteria->compare('ad_id',$this->ad_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('file_url',$this->file_url,true);
		$criteria->compare('link_url',$this->link_url,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('listorder',$this->listorder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdvertItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created',
				'updateAttribute' => null,
			),
			'UpdateCacheBehavior'=>array(
				'class'=>'application.components.behaviors.UpdateCacheBehavior',
				'cacheName'=>'AdvertCache',
			),
			'AttachmentRelationBehavior' => array(
				'class'=>'application.components.behaviors.AttachmentRelationBehavior',
				'attributes'=>array('file_url'=>false),
				'modelName'=>'AdvertItem',
			),
		);
	}
	
	public function afterSave(){
		if($this->getIsNewRecord()){
			Advert::model()->updateCounters(array('num'=>1),'id='.$this->ad_id);
		}
		return parent::afterSave();
	}
	
	public function afterDelete(){
		Advert::model()->updateCounters(array('num'=>-1),'id='.$this->ad_id);
		return parent::afterDelete();
	}
}
