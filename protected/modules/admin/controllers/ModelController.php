<?php

class ModelController extends AdminController {
	
	public function actionIndex(){
		$data['model_list']=ModelObject::model()->findAll();
		$this->render('index',$data);
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.modelForm');
		$model=new ModelObject();
		$form['base']->model=$model;
		$form['manage']->model=$model;
		if(isset($_POST['ajax']) && $_POST['ajax']==='model_form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('model_form_button') && $form->validate()){
			$model->name=$form['base']->model->name;
			$model->module=$form['base']->model->module;
			$model->controller=$form['base']->model->controller;
			$model->action=$form['base']->model->action;
			$model->object=$form['base']->model->object;
			$model->data=$form['base']->model->data;
			$model->data_num=$form['base']->model->data_num;
			$model->m_module=$form['manage']->model->m_module;
			$model->m_controller=$form['manage']->model->m_controller;
			$model->m_action=$form['manage']->model->m_action;
			$model->m_data=$form['manage']->model->m_data;			
			if($model->save(false)){
				$this->redirectMessage("模型添加保存成功！", Yii::app()->createUrl('admin/model/index'),'success');
			}
		}
		$data['form']=$form;
		$this->render('create',$data);		
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$model_info=ModelObject::model()->findByPk((int)$_GET['id']);
		if($model_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.modelForm');
		$form['base']->model=$model_info;
		$form['manage']->model=$model_info;
		if(isset($_POST['ajax']) && $_POST['ajax']==='model_form'){
			echo CActiveForm::validate($model_info);
			Yii::app()->end();
		}
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('model_form_button') && $form->validate()){
		    $model_info->name=$form['base']->model->name;
			$model_info->module=$form['base']->model->module;
			$model_info->controller=$form['base']->model->controller;
			$model_info->action=$form['base']->model->action;
			$model_info->object=$form['base']->model->object;
			$model_info->data=$form['base']->model->data;
			$model_info->data_num=$form['base']->model->data_num;
			$model_info->m_module=$form['manage']->model->m_module;
			$model_info->m_controller=$form['manage']->model->m_controller;
			$model_info->m_action=$form['manage']->model->m_action;
			$model_info->m_data=$form['manage']->model->m_data;
			if($model_info->save(false)){
				$this->redirectMessage("模型修改保存成功！", Yii::app()->createUrl('admin/model/index'),'success');
			}
		}
		$data['form']=$form;
		$this->render('create',$data);		
	}
	
	public function actions()
	{
		return array(
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'ModelObject',
				'message'    => array('success'=>'模型删除成功！','bizrule'=>'无法删除,模型存在数据！'),
				'redirectTo' => 'admin/model/index',
				'bizrule'    => '$is_judge=$model->items>1;',
			),
		);
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	
}