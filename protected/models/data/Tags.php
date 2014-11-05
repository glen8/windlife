<?php

/**
 * This is the model class for table "{{tags}}".
 *
 * The followings are the available columns in table '{{tags}}':
 * @property integer $id
 * @property string $title
 * @property integer $num
 * @property integer $post_id
 * @property string $created
 * @property string $updated
 * @property integer $hits
 * @property integer $listorder
 */
class Tags extends BaseModel
{
	/**
	 * @return string the associated database table name
	 */
    public $total_num;

	public function tableName()
	{
		return '{{tags}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, post_id', 'required'),
			array('num, post_id, hits, listorder', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('created, updated, total_num', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, num, post_id, created, updated, hits, listorder', 'safe', 'on'=>'search'),
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
			'title' => '标签名称',
			'num' => '内容数量',
			'post_id' => '创建人',
			'created' => 'Created',
			'updated' => 'Updated',
			'hits' => '点击次数',
			'listorder' => 'Listorder',
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
		$criteria->compare('num',$this->num);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('hits',$this->hits);
		$criteria->compare('listorder',$this->listorder);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tags the static model class
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
	    );
	}


	public function beforeDelete(){
		TagsItem::model()->deleteAllByAttributes(array('tags_id'=>$this->id));
		return parent::beforeDelete();
	}
}
