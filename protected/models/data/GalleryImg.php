<?php

/**
 * This is the model class for table "{{gallery_img}}".
 *
 * The followings are the available columns in table '{{gallery_img}}':
 * @property integer $id
 * @property integer $gallery_id
 * @property string $model_name
 * @property integer $model_id
 * @property string $img_url
 * @property string $alt
 */
class GalleryImg extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{gallery_img}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gallery_id, model_name, img_url', 'required'),
			array('gallery_id, model_id', 'numerical', 'integerOnly'=>true),
			array('model_name', 'length', 'max'=>20),
			array('img_url, alt', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gallery_id, model_name, model_id, img_url, alt', 'safe', 'on'=>'search'),
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
			'gallery_id' => '图集编号',
			'model_name' => '模型名称',
			'model_id' => '模型编号',
			'img_url' => '图片地址',
			'alt' => '描述',
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
		$criteria->compare('gallery_id',$this->gallery_id);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('img_url',$this->img_url,true);
		$criteria->compare('alt',$this->alt,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GalleryImg the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors(){
		return array(
			'CSafeContentBehavior' => array(
				'class'=>'application.components.behaviors.CSafeContentBehavior',
				'attributes'=>array('alt'),
			),
			'BadwordFilterBehavior' => array(
				'class'=>'application.components.behaviors.BadwordFilterBehavior',
				'attributes'=>array('alt'),
			),
			'AttachmentRelationBehavior' => array(
				'class'=>'application.components.behaviors.AttachmentRelationBehavior',
				'attributes'=>array('img_url'=>false),
				'modelName'=>'GalleryImg',
			),
		);
	}
}
