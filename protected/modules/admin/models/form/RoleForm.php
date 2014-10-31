<?php

class RoleForm  extends AdminFormModel{
	
	public $name;
	public $description;
	public $bizrule;
	public $data;
	
	public function rules(){
		return array(
			array('name', 'required', 'message'=>'请输入角色名称'),
			array('name', 'role_name_is_exist', 'on'=>'create'),
			array('description', 'required', 'message'=>'请输入角色描述'),
			array('bizrule, data', 'safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'name'=>'角色名称',
			'description'=>'角色描述',
			'bizrule'=>'业务规则',
			'data'=>'其他参数',
		);
	}
	
	public function role_name_is_exist($attribute,$params){
		$role=Yii::app()->authManager->getAuthItem($this->$attribute);
		if($role!==null){
			$this->addError($attribute, '此角色名称已存在');
		}
	}
	
}

?>