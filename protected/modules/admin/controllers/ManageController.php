<?php

class ManageController extends AdminController
{
	
	public function actionIndex(){
		$data['models']=Admin::model()->order('id ASC')->findAll();
		$this->render('index',$data);
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.adminForm');
		$form['admin']->model=new Admin('create');
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin_form'){
			echo CActiveForm::validate($form['admin']->model);
			Yii::app()->end();
		}
		if($form->submitted('admin_form_button') && $form->validate()){
			$admin=$form['admin']->model;
			$admin->password=CPasswordHelper::hashPassword($admin->password);
			if($admin->save(false)){
				$auth=Yii::app()->authManager;
				$auth->assign($admin->role_name, $admin->id);
				$this->redirectMessage("管理员添加保存成功！", Yii::app()->createUrl('admin/manage/index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$admin_info=Admin::model()->findByPk((int)$_GET['id']);
		if($admin_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$auth=Yii::app()->authManager;
		$form=new CForm('application.modules.admin.components.forms.adminForm');
		$admin_info->scenario='update';
		$tmp_role_name='';
		if($admin_info->is_default==0){
			$admin_info->role_name=Yii::app()->user->getAdminRoleName($admin_info->id);
			$tmp_role_name=Yii::app()->user->getAdminRoleName($admin_info->id);
		}
		$form['admin']->model=$admin_info;
		$form['admin']->elements['password']->value='';
		if($admin_info->is_default==1){
			$form['admin']->elements['role_name']->attributes=array('disabled'=>'disabled');
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin_form'){
			echo CActiveForm::validate($form['admin']->model);
			Yii::app()->end();
		}
		if($form->submitted('admin_form_button') && $form->validate()){
			$admin=$form['admin']->model;
			if(!empty($admin->password)){
			    $admin->password=CPasswordHelper::hashPassword($admin->password);
			}
			else {
				unset($admin->password);
			}
			if($admin->save(false)){		
				$auth->revoke($tmp_role_name, $admin_info->id);
				if($admin_info->is_default==0&&!$auth->isAssigned($admin->role_name, $admin->id)){
				    $auth->assign($admin->role_name, $admin->id);
				}
				$this->redirectMessage("管理员修改保存成功！", Yii::app()->createUrl('admin/manage/index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
			}
		}
		$this->render('update',array('form'=>$form));
	}
	
	public function actionDelete(){
		if(!Yii::app()->request->getIsPostRequest()){
			throw new CHttpException ( 400 , '删除需要POST提交');
		}
		$id=Yii::app ()->request->getParam ('id');
		if(empty($id)){
			throw new CHttpException ( 404 , '信息不存在');
		}
		$admin=Admin::model()->findByPk((int)$id);
		if(!$admin){
			throw new CHttpException ( 404 , '信息不存在');
		}
		if($admin->is_default==1){
			throw new CHttpException ( 403 , '系统默认管理员无法删除');
		}
		$auth=Yii::app()->authManager;
		$role=$auth->getAuthAssignments($admin->id);
		foreach ($role as $k=>$v){
			$auth->revoke($k, $admin->id);
		}
		if($admin->delete()){
			$this->redirectMessage("管理员删除成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success');
		}
		throw new CHttpException ( 500 ,'系统错误');
		
	}
	
	public function actionProfile()
	{
		$model=Admin::model()->findByPk(Yii::app()->user->id);
		if($model===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$model->scenario='profile';
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile_form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Admin'])){
			$model->attributes=$_POST['Admin'];
			if($model->validate(array('name','email'))&&$model->save(false)){
				$this->redirectMessage("操作成功", Yii::app()->createUrl($this->redirect_url.'profile'),'success');
			}
		}
		$this->render('profile',array('model'=>$model));
	}
	
	public function actionChangepass(){
		$model=Admin::model()->findByPk(Yii::app()->user->id);
		if($model===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$model->scenario='changepass';
		$model->password='';
		if(isset($_POST['ajax']) && $_POST['ajax']==='changepass_form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Admin'])){
			$model->attributes=$_POST['Admin'];
			if($model->validate(array('old_password','password','r_password'))){
				$model->password=CPasswordHelper::hashPassword($_POST['Admin']['password']);
				if($model->save(false)){
					$this->redirectMessage("密码修改成功", Yii::app()->createUrl($this->redirect_url.'changepass'),'success');
				}				
			}
		}
		$this->render('changepass',array('model'=>$model));
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
}