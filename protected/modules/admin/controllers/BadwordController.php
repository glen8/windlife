<?php

class BadwordController extends AdminController
{
	public function actionIndex()
	{
		$search_model=new Badword('search');
		$criteria = new CDbCriteria();
		$url_args=array();
		if(isset($_GET['Badword'])){
			$search_model->attributes=$_GET['Badword'];
			foreach ($_GET['Badword'] as $k=>$v){
				if(empty($v)) continue;
				$url_args[$k]=$v;
				$criteria->addSearchCondition($k, $v);
			}
		}
		else{
			foreach ($_GET as $k=>$v){
				if(array_key_exists($k,$search_model->attributes)){
					if(empty($v)) continue;
					$url_args[$k]=$v;
					$search_model->$k=$v;
					$criteria->addSearchCondition($k, $v);
				}
			}
		}
		$criteria->order='lastusetime DESC';
		$count=Badword::model()->count($criteria);
		$pages=new CPagination($count);
		if(!empty($url_args)){
			$pages->params=$url_args;
		}
		$pages->pageSize=12;
		$pages->applyLimit($criteria);
		$models = Badword::model()->findAll($criteria);
		$this->render('index', array('models' => $models, 'search_model'=>$search_model, 'pages' => $pages));		
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.badwordForm');
		$form['badword']->model=new Badword();
		if(isset($_POST['ajax']) && $_POST['ajax']==='badword_form'){
			echo CActiveForm::validate($form['badword']->model);
			Yii::app()->end();
		}
		if($form->submitted('badword_form_button') && $form->validate()){
			$badword=$form['badword']->model;
			if($badword->save(false)){
				$this->redirectMessage("敏感词添加保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$badword_info=Badword::model()->findByPk((int)$_GET['id']);
		if($badword_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.badwordForm');
		$form['badword']->model=$badword_info;
		if(isset($_POST['ajax']) && $_POST['ajax']==='badword_form'){
			echo CActiveForm::validate($form['badword']->model);
			Yii::app()->end();
		}
		if($form->submitted('badword_form_button') && $form->validate()){
			$badword=$form['badword']->model;
			if($badword->save(false)){
				$this->redirectMessage("敏感词修改保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actions(){
		return array(
			'delete'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Badword',
				'message'    => array('success'=>'敏感词删除成功！'),
				'redirectTo' => 'admin/badword/index',
			),
			'deleteAll'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAllAction',
				'modelClass' => 'Badword',
				'message'    => array('success'=>'选择的敏感词删除成功！'),
				'redirectTo' => 'admin/badword/index',
			),
		);
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	
}