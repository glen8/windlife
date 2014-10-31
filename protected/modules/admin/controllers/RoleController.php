<?php

class RoleController extends AdminController
{
	public function actionIndex()
	{
		$data['models']=Yii::app()->authManager->getRoles();
		$this->render('index',$data);
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.roleForm');
		$role=new RoleForm();
		$role->scenario='create';
		$form['role']->model=new RoleForm();
		if(isset($_POST['ajax']) && $_POST['ajax']==='role_form'){
			echo CActiveForm::validate($form['role']->model);
			Yii::app()->end();
		}
		if($form->submitted('role_form_button') && $form->validate()){
			$role=$form['role']->model;
			$auth=Yii::app()->authManager;
			if($auth->createRole($role->name,$role->description,$role->bizrule,$role->data)!==null){
				$this->redirectMessage("角色添加保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$auth=Yii::app()->authManager;
		$role_info=$auth->getAuthItem($_GET['id']);
		if($role_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.roleForm');
		$role=new RoleForm();
		$role->name=$role_info->name;
		$role->description=$role_info->description;
		$role->bizrule=$role_info->bizrule;
		$role->data=$role_info->data;
		$form['role']->model=$role;
		$form['role']->elements['name']->attributes=array('readonly'=>'readonly','class'=>'input-text');
		if(isset($_POST['ajax']) && $_POST['ajax']==='role_form'){
			echo CActiveForm::validate($form['role']->model);
			Yii::app()->end();
		}
		if($form->submitted('role_form_button') && $form->validate()){
			$role=$form['role']->model;
			$auth=Yii::app()->authManager;
			$auth->saveAuthItem(new CAuthItem($auth, $role->name, $role_info->getType(),$role->description,$role->bizrule,$role->data),$role_info->getName());
			$this->redirectMessage("角色修改保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionDelete(){
		if(!Yii::app()->request->getIsPostRequest()){
			throw new CHttpException ( 400 , '删除需要POST提交');
		}
		$role_name=Yii::app ()->request->getParam ('id');
		if(empty($role_name)){
			throw new CHttpException ( 404 , '信息不存在');
		}
		$auth=Yii::app()->authManager;
		if($auth->getAuthItem($role_name)===null){
			throw new CHttpException ( 404 , '角色不存在');
		}
		if($auth->removeAuthItem($role_name)){
			$this->redirectMessage("角色删除成功！", Yii::app()->createUrl('admin/role/index'),'success');
		}
	}
	
	public function actionSetAccess(){
		$role_name=Yii::app ()->request->getParam ('id');
		if(empty($role_name)){
			throw new CHttpException ( 404 , '信息不存在');
		}
		$auth=Yii::app()->authManager;
		$role=$auth->getAuthItem($role_name);
		if(count($role)<1){
			throw new CHttpException ( 404 , '信息不存在');
		}
		$data['role']=$role;
		$data['role_childs']=$role->getChildren();
		$data['tasks']=$auth->getTasks();
		if(isset($_POST['role_access'])){
			Yii::app()->db->createCommand()->delete('{{authitemchild}}','parent=:parent',array(':parent'=>$role_name));
			foreach ($_POST['role_access'] as $v){
			    $role->addChild($v);
			}
			$this->redirectMessage("角色绑定权限成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success');
		}
        $this->render('setaccess',$data);
	}
		
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}

}