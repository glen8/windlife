<?php

class CopyfromController extends AdminController
{
	
	public function actionIndex()
	{
		$data['models']=Copyfrom::model()->order('listorder ASC,id ASC')->findAll();
		$this->render('index', $data);
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.copyfromForm');
		$form['copyfrom']->model=new Copyfrom();
		if(isset($_POST['ajax']) && $_POST['ajax']==='copyfrom_form'){
			echo CActiveForm::validate($form['copyfrom']->model);
			Yii::app()->end();
		}
		if($form->submitted('copyfrom_form_button') && $form->validate()){
			$copyfrom=$form['copyfrom']->model;
			if($copyfrom->save(false)){
				$this->redirectMessage("来源添加保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$copyfrom_info=Copyfrom::model()->findByPk((int)$_GET['id']);
		if($copyfrom_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.copyfromForm');
		$form['copyfrom']->model=$copyfrom_info;
		if(isset($_POST['ajax']) && $_POST['ajax']==='copyfrom_form'){
			echo CActiveForm::validate($form['copyfrom']->model);
			Yii::app()->end();
		}
		if($form->submitted('copyfrom_form_button') && $form->validate()){
			$copyfrom=$form['copyfrom']->model;
			if($copyfrom->save(false)){
				$this->redirectMessage("来源修改保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}

	public function actions(){
		return array(
			'delete'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Copyfrom',
				'message'    => array('success'=>'来源删除成功！'),
				'redirectTo' => 'admin/copyfrom/index',
			),
			'imageManager'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageManager',
			),
			'imageUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageUp',
			),
			'remoteImage'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.RemoteImage',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'Copyfrom',
				'redirectTo' => 'admin/copyfrom/index',
			),
		);
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	
}