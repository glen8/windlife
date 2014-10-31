<?php

class SettingBaseForm extends AdminFormModel
{
    
	public $title;
	public $subTitle;
	public $domain;
	public $metaKeyword;
	public $metaDescription;
	public $email;
	public $telephone;
	public $phone;
	public $fax;
	public $zip;
	public $address;
	public $certs;
	public $qq1;
	public $qq2;
	

	public function rules()
	{
		return array(
			array('domain', 'url', 'allowEmpty'=>true, 'message'=>'请正确输入网站网址'),
			array('email', 'email', 'allowEmpty'=>true,'message'=>'请正确输入邮箱地址'),
			array('telephone', 'match', 'allowEmpty'=>true, 'pattern'=>'/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/','message'=>'请正确输入电话号码'),
			array('phone', 'match', 'allowEmpty'=>true, 'pattern'=>'/^1(3|4|5|8])\d{9}$/','message'=>'请正确输入手机号码'),
			array('fax', 'match', 'allowEmpty'=>true, 'pattern'=>'/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/','message'=>'请正确输入传真号码'),
			array('zip', 'match', 'allowEmpty'=>true, 'pattern'=>'/^[1-9][0-9]{5}$/','message'=>'请正确输入邮政编码'),	
			array('qq1', 'match', 'allowEmpty'=>true, 'pattern'=>'/^\d{5,15}$/','message'=>'请正确输入QQ号码'),
			array('qq2', 'match', 'allowEmpty'=>true, 'pattern'=>'/^\d{5,15}$/','message'=>'请正确输入QQ号码'),
			array('title, subTitle, domain, metaKeyword, metaDescription, email, telephone, phone, fax, zip, address, certs, qq1, qq2', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'title'=>'网站名称',
			'subTitle'=>'网站副标题',
			'domain'=>'网站网址',
			'metaKeyword'=>'网站关键词',
			'metaDescription'=>'网站描述',
			'email'=>'联系邮箱',
			'telephone'=>'联系电话',
			'phone'=>'手机号码',
			'fax'=>'传真',
			'zip'=>'邮编',
			'address'=>'联系地址',
			'certs'=>'备案号',
			'qq1'=>'QQ客服1',
			'qq2'=>'QQ客服2'
		);
	}
	
}
