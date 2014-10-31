<?php

class SettingEmailForm extends AdminFormModel
{
	public $server;
	public $port;
	public $address;
	public $username;
	public $password;
	public $test;


	public function rules()
	{
		return array(
			array('port','numerical','allowEmpty'=>true,'message'=>'请填写正整数'),
			array('address,username,test', 'email', 'allowEmpty'=>true,'message'=>'请填写输入邮箱地址格式'),
			array('server,port,address,username,password,test','safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'server'=>'邮件服务器',
			'port'=>'邮件发送端口',
			'address'=>'发件人地址',
			'username'=>'验证用户名',
			'password'=>'验证密码',
			'test'=>'邮件设置测试',
		);
	}

}
