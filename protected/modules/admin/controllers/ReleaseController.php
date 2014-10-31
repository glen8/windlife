<?php

class ReleaseController extends AdminController
{
	public function actionIndex(){
		$models=Release::model()->findAll();
		Yii::app()->cacheManage->cacheName='PositionCache';		
		$position_cache=Yii::app()->cacheManage->findCache();
		$position_array=isset($position_cache[0])?$position_cache[0]:array();
		Yii::app()->cacheManage->cacheName='ModelCache';
		$model_cache=Yii::app()->cacheManage->findCache();
		$this->render('index',array('models'=>$models,'position'=>$position_array,'model'=>$model_cache));
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.releaseForm');
		$form['release']->model=new Release();
		Yii::app()->cacheManage->cacheName='PositionCache';
		$position_cache=Yii::app()->cacheManage->findCache();
		$position_array=isset($position_cache[0])?$position_cache[0]:array();
		$form['release']->elements['key_name']->items=$position_array;
		Yii::app()->cacheManage->cacheName='ModelCache';
		$model_cache=Yii::app()->cacheManage->findCache();
		$form['release']->elements['model_id']->items=CHtml::listData($model_cache, 'id', 'name');
		if(isset($_POST['ajax']) && $_POST['ajax']==='release_form'){
			echo CActiveForm::validate($form['release']->model);
			Yii::app()->end();
		}
		if($form->submitted('release_form_button') && $form->validate()){
			$menu=$form['release']->model;
			if($menu->save(false)){
				$this->redirectMessage("内容发布添加保存成功！", Yii::app()->createUrl('admin/release/index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$release_info=Release::model()->findByPk((int)$_GET['id']);
		if($release_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.releaseForm');
		$form['release']->model=$release_info;
        Yii::app()->cacheManage->cacheName='PositionCache';
		$position_cache=Yii::app()->cacheManage->findCache();
		$position_array=isset($position_cache[0])?$position_cache[0]:array();
		$form['release']->elements['key_name']->items=$position_array;
		Yii::app()->cacheManage->cacheName='ModelCache';
		$model_cache=Yii::app()->cacheManage->findCache();
		$form['release']->elements['model_id']->items=CHtml::listData($model_cache, 'id', 'name');
		$form['release']->elements['key_name']->attributes=array('disabled'=>'disabled');
		if(isset($_POST['ajax']) && $_POST['ajax']==='release_form'){
			echo CActiveForm::validate($form['release']->model);
			Yii::app()->end();
		}
		if($form->submitted('release_form_button') && $form->validate()){
			$release=$form['release']->model;			
			if($release->save(false)){
				$this->redirectMessage("发布内容修改保存成功！", Yii::app()->createUrl('admin/release/index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionList(){
		if(!isset($_GET['release_id'])&&empty($_GET['release_id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		Yii::app()->cacheManage->cacheName='ContentCache';
		$data['column_data']=Yii::app()->cacheManage->findCache();
		Yii::app()->cacheManage->cacheName='ModelCache';
		$data['model_data']=Yii::app()->cacheManage->findCache();
		$data['release_info']=Release::model()->findByPk((int)$_GET['release_id']);
		$criteria = new CDbCriteria();
		$criteria->addCondition('release_id=' . (int)$_GET['release_id']);
		$url_args=array();
		$url_args['release_id']=(int)$_GET['release_id'];
		$count=ReleaseContent::model()->count($criteria);
		$pages=new CPagination($count);
		if(!empty($url_args)){
			$pages->params=$url_args;
		}
		$pages->pageSize=12;
		$pages->applyLimit($criteria);
		$data['pages']=$pages;
		$data['models'] = ReleaseContent::model()->findAll($criteria);
		$this->render('list',$data);		
	}
	
	public function actions()
	{
		return array(
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Release',
				'message'    => array('success'=>'内容发布删除！'),
				'redirectTo' => 'admin/release/index',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'ReleaseContent',
				'message'    => array('success'=>'操作成功！'),
				'redirectTo' => 'admin/release/list',
				'redirectParam' => isset($_GET['release_id'])?array('release_id'=>(int)$_GET['release_id']):null
			),
			'cdelete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'ReleaseContent',
				'message'    => array('success'=>'内容删除！'),
				'redirectTo' => 'admin/release/list',
				'redirectParam' => isset($_GET['release_id'])?array('release_id'=>(int)$_GET['release_id']):null
			),
		);
	}
	
	public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	

	
}