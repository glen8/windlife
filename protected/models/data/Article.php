<?php

/**
 * This is the model class for table "{{article}}".
 *
 * The followings are the available columns in table '{{article}}':
 * @property string $id
 * @property integer $column_id
 * @property integer $model_id
 * @property string $title
 * @property string $style
 * @property string $thumb
 * @property string $keywords
 * @property string $description
 * @property string $copyfrom
 * @property string $content
 * @property string $url
 * @property integer $listorder
 * @property integer $status
 * @property integer $islink
 * @property integer $admin_id 
 * @property integer $hits
 * @property string $inputtime
 * @property string $updatetime
 */
class Article extends BaseModel
{
	public $search_begintime;
	public $search_endtime;
	public $search_field;
	public $search_value;
	
	public $release_content;
	
	public $tags_list;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{article}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content, admin_id', 'required'),
			array('column_id,  model_id, listorder, status, islink, admin_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>80),
			array('description','safe'),
			array('style', 'length', 'max'=>24),
			array('thumb, copyfrom, url', 'length', 'max'=>100),
			array('keywords', 'length', 'max'=>40),
			array('hits, inputtime, updatetime,release_content,tags_list', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, column_id, title, style, thumb, keywords, description, copyfrom, content, url, listorder, status, islink, admin_id, inputtime, updatetime', 'safe', 'on'=>'search'),
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
			'model_id' => '模型编号',
			'title' => '标题',
			'style' => '标题样式',
			'thumb' => '缩略图',
			'keywords' => '关键词',
			'description' => '摘要',
			'copyfrom' => '来源',
			'content' => '内容',
			'url' => 'URL',
			'listorder' => '排序',
			'status' => '状态',
			'islink' => '转向链接',
			'admin_id' => '发布人编号',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('style',$this->style,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('keywords',$this->keywords,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('copyfrom',$this->copyfrom,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('listorder',$this->listorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('islink',$this->islink);
		$criteria->compare('admin_id',$this->admin_id);
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
	 * @return Article the static model class
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
				'modelName'=>'Article',
			),
			'UpdateObjectItemsBehavior' => array(
				'class'=>'application.components.behaviors.UpdateObjectItemsBehavior',
			),
			'ReleaseContentBehavior' => array(
				'class'=>'application.components.behaviors.ReleaseContentBehavior',
			),
		    'TagsBehavior' => array(
		        'class'=>'application.components.behaviors.TagsBehavior',
		        'modelName'=>'Article',
		    ),
		);
	}
}
