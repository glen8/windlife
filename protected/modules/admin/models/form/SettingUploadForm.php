<?php

class SettingUploadForm extends AdminFormModel
{
	public $size;
	public $fileType;
	public $isWater;
	public $waterWith;
	public $waterHeight;
    public $waterName;
    public $waterTouming;
    public $waterQuality;
    public $thumbQuality;
    public $waterPosition;
	


	public function rules()
	{
		return array(
			array('size,waterWith,waterHeight','numerical','allowEmpty'=>true,'message'=>'请填写正整数'),
			array('waterTouming,waterQuality,thumbQuality','numerical','allowEmpty'=>true,'message'=>'请填写0-100内的正整数','max'=>100,'min'=>0, 'tooBig'=>'请填写0-100内的正整数','tooSmall'=>'请填写0-100内的正整数'),
			array('size, fileType, isWater, waterWith, waterHeight, waterName, waterTouming, waterQuality, thumbQuality, waterPosition', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'size'=>'允许上传附件大小',
			'fileType'=>'允许上传附件类型',
			'isWater'=>'是否开启图片水印',
			'waterWith'=>'水印添加最小宽度',
			'waterHeight'=>'水印添加图片最小高度',
			'waterName'=>'水印图片名称',
			'waterTouming'=>'水印图片透明度',
			'waterQuality'=>'水印图片质量',
			'thumbQuality'=>'图片缩略图质量',
			'waterPosition'=>'水印位置'
		);
	}

}
