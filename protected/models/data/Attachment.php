<?php

/**
 * This is the model class for table "{{attachment}}".
 *
 * The followings are the available columns in table '{{attachment}}':
 * @property string $id
 * @property string $filename
 * @property string $filepath
 * @property string $filesize
 * @property string $fileext
 * @property string $filedesn
 * @property integer $isimage
 * @property integer $isthumb
 * @property integer $isscrawl
 * @property integer $isremote
 * @property integer $downloads
 * @property integer $userid
 * @property string $uploadtime
 * @property string $uploadip
 * @property integer $status
 */
class Attachment extends BaseModel
{
	
	public $search_begintime;
	public $search_endtime;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{attachment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('filename, filepath, fileext, uploadip', 'required'),
			array('isimage, isthumb, isscrawl, isremote, downloads, userid, status', 'numerical', 'integerOnly'=>true),
			array('filename, filedesn', 'length', 'max'=>50),
			array('filepath', 'length', 'max'=>200),
			array('filesize, fileext, uploadtime', 'length', 'max'=>10),
			array('uploadip', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, filename, filepath, filesize, fileext, filedesn, isimage, isthumb, isscrawl, isremote, downloads, userid, uploadtime, uploadip, status', 'safe', 'on'=>'search'),
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
			'items'=>array(self::HAS_MANY,'AttachmentItem','attachment_id'),
			'itemCount'=>array(self::STAT,'AttachmentItem','attachment_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'filename' => '文件名称',
			'filepath' => '文件路径',
			'filesize' => '文件大小',
			'fileext' => '文件后缀',
			'filedesn' => '文件描述',
			'isimage' => '是否为图片',
			'isthumb' => '是否为缩略图',
			'isscrawl' => '是否为涂鸦图片',
			'isremote' => '是否为远程图片',
			'downloads' => '下载次数',
			'userid' => '上传用户ID',
			'uploadtime' => '上传时间',
			'uploadip' => '上传IP',
			'status' => '状态',
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
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('filepath',$this->filepath,true);
		$criteria->compare('filesize',$this->filesize,true);
		$criteria->compare('fileext',$this->fileext,true);
		$criteria->compare('filedesn',$this->filedesn,true);
		$criteria->compare('isimage',$this->isimage);
		$criteria->compare('isthumb',$this->isthumb);
		$criteria->compare('isscrawl',$this->isscrawl);
		$criteria->compare('isremote',$this->isremote);
		$criteria->compare('downloads',$this->downloads);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('uploadtime',$this->uploadtime,true);
		$criteria->compare('uploadip',$this->uploadip,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attachment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function afterSave(){
		Yii::app()->cacheManage->cacheName='SettingCache';
		$setting_cache=Yii::app()->cacheManage->findCache();
		$setting_upload=unserialize($setting_cache['upload']['value']);
		$is_image=$this->fileext=='.jpg'||$this->fileext=='.jpeg'||$this->fileext=='.png'||$this->fileext=='.gif'||$this->fileext=='.bmp';
		if(is_file($this->filepath)&&$is_image&&isset($setting_upload['isWater'])&&isset($setting_upload['waterName'])&&is_file('./images/water/'.$setting_upload['waterName'])){
			$img_size=getimagesize($this->filepath);
			if($img_size[0]>=$setting_upload['waterWith']&&$img_size[1]>=$setting_upload['waterHeight']){
				Yii::import('application.extensions.wl_waterMark.WLWaterMark');
				switch ($setting_upload['waterPosition']){
					case 1:
						WLWaterMark::watermarkFromFile($this->filepath)->addImage('./images/water/'.$setting_upload['waterName'])->setPos('left','top')->save($this->filepath);
						break;
					case 2:
						WLWaterMark::watermarkFromFile($this->filepath)->addImage('./images/water/'.$setting_upload['waterName'])->setPos('center','center')->save($this->filepath);
						break;
					case 3:
						WLWaterMark::watermarkFromFile($this->filepath)->addImage('./images/water/'.$setting_upload['waterName'])->setPos('right','bottom')->save($this->filepath);						
						break;
					default:
						WLWaterMark::watermarkFromFile($this->filepath)->addImage('./images/water/'.$setting_upload['waterName'])->setPos('right','bottom')->save($this->filepath);						
						break;
				}
			}
		}
		return parent::afterSave();
	}
	
	public function afterDelete(){
	    @unlink($this->filepath);
		return parent::afterDelete();
	}
}
