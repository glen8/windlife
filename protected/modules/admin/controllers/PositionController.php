<?php

class PositionController extends AdminController
{
	public function actionIndex(){
		$models=Position::model()->findAll();
		$this->render('index',array('models'=>$models));
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.positionForm');
		$form['position']->model=new Position();
		if(isset($_POST['ajax']) && $_POST['ajax']==='position_form'){
			echo CActiveForm::validate($form['position']->model);
			Yii::app()->end();
		}
		if($form->submitted('position_form_button') && $form->validate()){
			$position=$form['position']->model;
			if($position->save(false)){
				$this->redirectMessage("发布位添加保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actions()
	{
		return array(
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Position',
				'message'    => array('success'=>'发布位删除成功！'),
				'redirectTo' => 'admin/position/index',
			),
		);
	}
	
	public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	
}