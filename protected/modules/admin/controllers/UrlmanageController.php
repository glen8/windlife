<?php

class UrlmanageController extends AdminController
{
	public function actionIndex()	{
		$data['urlrules']=Urlrule::model()->order('listorder ASC')->findAll();
		$this->render('index',$data);
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.urlruleForm');
		$form['urlrule']->model=new Urlrule();
		if(isset($_POST['ajax']) && $_POST['ajax']==='urlrule_form'){
			echo CActiveForm::validate($form['urlrule']->model);
			Yii::app()->end();
		}
		if($form->submitted('urlrule_form_button') && $form->validate()){
			$urlrule=$form['urlrule']->model;
			if($urlrule->save(false)){
				$this->redirectMessage("URL规则添加保存成功！", Yii::app()->createUrl('admin/urlmanage/index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$urlrule_info=Urlrule::model()->findByPk((int)$_GET['id']);
		if($urlrule_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.urlruleForm');
		$form['urlrule']->model=$urlrule_info;
		if(isset($_POST['ajax']) && $_POST['ajax']==='urlrule_form'){
			echo CActiveForm::validate($form['urlrule']->model);
			Yii::app()->end();
		}
		if($form->submitted('urlrule_form_button') && $form->validate()){
			$urlrule_info=$form['urlrule']->model;
			if($urlrule_info->save(false)){
				$this->redirectMessage("URL规则修改保存成功！", Yii::app()->createUrl('admin/urlmanage/index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actions()
	{
		return array(
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Urlrule',
				'message'    => array('success'=>'URL规则删除成功！'),
				'redirectTo' => 'admin/urlmanage/index',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'Urlrule',
				'redirectTo' => 'admin/urlmanage/index',
			),
		);
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}

}