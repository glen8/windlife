<?php

class AdminWebUser extends CWebUser{

	public function getAdminRoleName($userId=null){
		$roles=($userId==null?Yii::app()->authManager->getRoles(Yii::app()->user->id):Yii::app()->authManager->getRoles($userId));
		if(!empty($roles)){
			foreach ($roles as $k=>$v){
				return $k;
			}
		}
		return null;
	}
	
	public function getAdminRoleDescription($userId=null){
		$roles=($userId==null?Yii::app()->authManager->getRoles(Yii::app()->user->id):Yii::app()->authManager->getRoles($userId));
		if(!empty($roles)){
			foreach ($roles as $k=>$v){
				return $v->getDescription();
			}
		}
		return null;
	}
}

?>