<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property string $title
 * @property string $style
 * @property string $content
 * @property string $keyword
 * @property integer $column_id
 * @property integer $model_id
 * @property string $created
 * @property string $updated
 */
class Page extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('column_id, model_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('keyword', 'length', 'max'=>255),
			array('style, content, created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content, keyword, column_id, model_id, created, updated', 'safe', 'on'=>'search'),
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
			'title' => '标题',
			'style' => '标题样式',
			'content' => '内容',
			'keyword' => '关键词',
			'column_id' => '栏目编号',
			'model_id' => '模型编号',
			'created' => '创建时间',
			'updated' => '修改时间',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('style',$this->style,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('column_id',$this->column_id);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Page the static model class
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
				'updateAttribute' => 'updated',
			),
			'CSafeContentBehavior' => array(
				'class'=>'application.components.behaviors.CSafeContentBehavior',
				'attributes'=>array('title','keyword','content'),					
			),
			'BadwordFilterBehavior' => array(
				'class'=>'application.components.behaviors.BadwordFilterBehavior',
				'attributes'=>array('title','keyword','content'),
			),
			'AttachmentRelationBehavior' => array(
				'class'=>'application.components.behaviors.AttachmentRelationBehavior',
				'attributes'=>array('content'=>true),
				'modelName'=>'Page',
			),
			'UpdateObjectItemsBehavior' => array(
				'class'=>'application.components.behaviors.UpdateObjectItemsBehavior',
			),
		);
	}
}
