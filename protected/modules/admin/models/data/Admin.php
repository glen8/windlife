<?php

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $created
 * @property string $last_login 
 * @property string $last_ip
 * @property string $is_default
 */
class Admin extends AdminBaseModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Admin the static model class
	 */
	public $old_password;
	public $r_password;
	public $role_name;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{admin}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email', 'required','message'=>'必填项，请填写'),
			array('username', 'unique', 'criteria' => array('condition' => "username<>'{$this->username}'"),'message'=>'用户名已存在，请更改','on'=>'create,update'),
			array('username', 'length', 'max'=>50),
			array('password', 'length', 'max'=>40),
			array('password', 'length', 'min'=>6),
			array('email', 'length', 'max'=>100),
			array('email', 'email', 'message'=>'请输入正确的email地址'),
			array('last_login,last_ip,name,role_name', 'safe'),
			array('name', 'required', 'message'=>'真实姓名，请填写', 'on'=>'profile'),
			array('old_password','required','message'=>'请输入旧密码', 'on'=>'changepass'),
			array('old_password','old_password_is_right','on'=>'changepass'),
			array('password','required', 'message'=>'请输入新密码', 'on'=>'changepass,create'),
			array('r_password','compare', 'compareAttribute'=>'password', 'operator'=>'=' ,'message'=>'重复密码必须与新密码相同', 'on'=>'changepass,create,update'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, created, last_login, last_ip', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'username' => '用户名',
			'name' => '真实姓名',
			'password' => '密码',
			'email' => 'Email',
			'created' => '创建时间',
			'last_login' => '最后登录时间',
			'last_ip' => '最后登录ip',
			'is_default'=>'默认系统管理员',
			'r_password'=>'确认密码',
			'role_name'=>'角色'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('last_ip',$this->last_ip,true);
		$criteria->compare('is_default',$this->is_default,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	//取得角色
	public function wl_getRoles(){
		return Yii::app()->authManager->getRoles();
	}
	
	//验证旧密码
	public function old_password_is_right($attribute,$params){
	    $admin=$this->model()->findByPk(Yii::app()->user->id);
	    if(!CPasswordHelper::verifyPassword($this->$attribute, $admin->password)){
		    $this->addError($attribute, '旧密码输入错误');
	    }
	}
	
	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created',
				'updateAttribute' => null,
			)
		);
	}
}