<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity
{
	/**
	 * Authenticates a admin.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent admin identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	
	private $_id;
	
	public function authenticate()
	{
		$admin=Admin::model()->findByAttributes(array('username'=>$this->username));
		if($admin===null){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		elseif(!CPasswordHelper::verifyPassword($this->password, $admin->password)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else{
			$this->_id=$admin->id;
			$this->setState('last_login', $admin->last_login);
			$this->setState('last_ip', $admin->last_ip);
			$this->setState('is_default', $admin->is_default);
		    $admin->last_login=new CDbExpression('NOW()');
		    $admin->last_ip=Yii::app()->request->userHostAddress;
		    $admin->save(false);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	
	
	//锁屏登陆验证
	public function lockAuthenticate()
	{
		$admin=Admin::model()->findByAttributes(array('username'=>$this->username));
		if($admin===null){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		elseif(!CPasswordHelper::verifyPassword($this->password, $admin->password)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		else{
			$this->_id=$admin->id;
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	
	public function getId(){
		return $this->_id;
	}
	
}