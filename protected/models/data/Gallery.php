<?php

/**
 * This is the model class for table "{{gallery}}".
 *
 * The followings are the available columns in table '{{gallery}}':
 * @property string $id
 * @property integer $column_id
 * @property integer $model_id
 * @property integer $admin_id
 * @property string $title
 * @property string $style
 * @property string $thumb
 * @property string $keywords
 * @property string $description
 * @property string $content
 * @property string $url
 * @property integer $listorder
 * @property integer $status
 * @property integer $islink
 * @property integer $hits
 * @property string $inputtime
 * @property string $updatetime
 */
class Gallery extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public $search_begintime;
	public $search_endtime;
	public $search_field;
	public $search_value;
	
	public $release_content;
	
	//图集
	public $img_list;
	public $alt_list;
	
	public function tableName()
	{
		return '{{gallery}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, model_id, admin_id, content', 'required'),
			array('img_list','required','message'=>'请上传图集图片'),
			array('column_id, model_id, admin_id, listorder, status, islink, hits', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>80),
			array('style, thumb, url', 'length', 'max'=>100),
			array('keywords', 'length', 'max'=>40),
			array('inputtime, updatetime,release_content,alt_list', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, column_id, model_id, admin_id, title, style, thumb, keywords, description, content, url, listorder, status, islink, hits, inputtime, updatetime', 'safe', 'on'=>'search'),
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
			'poster'=>array(self::BELONGS_TO, 'Admin', 'admin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '自动编号',
			'column_id' => '栏目编号',
			'model_id' => 'Model',
			'admin_id' => '发布人编号',
			'title' => '标题',
			'style' => '标题样式',
			'thumb' => '缩略图',
			'keywords' => '关键词',
			'description' => '摘要',
			'content' => '内容',
			'url' => 'URL',
			'listorder' => '排序',
			'status' => '状态',
			'islink' => '转向链接',
			'hits' => '点击率',
			'inputtime' => '添加时间',
			'updatetime' => '更新时间',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('column_id',$this->column_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('style',$this->style,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('islink',$this->islink);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('inputtime',$this->inputtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gallery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function behaviors(){
		return array(
			'CSafeContentBehavior' => array(
				'class'=>'application.components.behaviors.CSafeContentBehavior',
				'attributes'=>array('title','keywords','description','content'),
			),
			'BadwordFilterBehavior' => array(
				'class'=>'application.components.behaviors.BadwordFilterBehavior',
				'attributes'=>array('title','keywords','description','content'),
			),
			'AttachmentRelationBehavior' => array(
				'class'=>'application.components.behaviors.AttachmentRelationBehavior',
				'attributes'=>array('thumb'=>false,'content'=>true),
				'modelName'=>'Gallery',
			),
			'UpdateObjectItemsBehavior' => array(
				'class'=>'application.components.behaviors.UpdateObjectItemsBehavior',
			),	
			'MultipleImageUploadBehavior' => array(
				'class'=>'application.components.behaviors.MultipleImageUploadBehavior',
				'attribute_img'=>'img_list',
				'attribute_alt'=>'alt_list'
			),
		);
	}
}
