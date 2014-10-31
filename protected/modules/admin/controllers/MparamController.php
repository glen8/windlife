<?php

class MparamController extends AdminController
{
	public function actionIndex()
	{
		$data['model_data']=$this->__ModelInfo();
		$data['models']=ModelParam::model()->order('listorder ASC,id DESC')->findAll('model_id=:model_id',array('model_id'=>(int)$_GET['model_id']));
		$this->render('index',$data);
	}
	
	public function actionCreate(){
		$model_data=$this->__ModelInfo();
		$form=new CForm('application.modules.admin.components.forms.mparamForm');
		$mparam=new ModelParam();
		$mparam->model_id=(int)$_GET['model_id'];
		$form['mparam']->model=$mparam;
		if(isset($_POST['ajax']) && $_POST['ajax']==='mparam_form'){
			echo CActiveForm::validate($form['mparam']->model);
			Yii::app()->end();
		}
		if($form->submitted('mparam_form_button') && $form->validate()){
			$mparam=$form['mparam']->model;
			if(!empty($form['mparam']->model->value_items)){
				$mparam->value_items=serialize(Util::text2array($form['mparam']->model->value_items));
			}
			if($mparam->save(false)){
				$this->redirectMessage("“{$model_data['name']}” 添加保存成功！", Yii::app()->createUrl('admin/mparam/index',array('model_id'=>(int)$_GET['model_id'])),'success');
			}
		}
		$this->render('create',array('form'=>$form,'model_data'=>$model_data));
	}
	
	public function actionUpdate(){
		$model_data=$this->__ModelInfo();
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$mparam_info=ModelParam::model()->findByPk((int)$_GET['id']);
		if($mparam_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.mparamForm');
		$form['mparam']->model=$mparam_info;
		$form['mparam']->model->value_items=Util::array2text(unserialize($mparam_info->value_items));
		if(isset($_POST['ajax']) && $_POST['ajax']==='mparam_form'){
			echo CActiveForm::validate($form['mparam']->model);
			Yii::app()->end();
		}
		if($form->submitted('mparam_form_button') && $form->validate()){
			$mparam=$form['mparam']->model;
			if(!empty($form['mparam']->model->value_items)){
				$mparam->value_items=serialize(Util::text2array($form['mparam']->model->value_items));
			}
			if($mparam->save(false)){
				$this->redirectMessage("“{$model_data['name']}” 修改保存成功！", Yii::app()->createUrl('admin/mparam/index',array('model_id'=>(int)$_GET['model_id'])),'success');
			}
		}
		$this->render('create',array('form'=>$form,'model_data'=>$model_data));
	}
	
	public function actions()
	{
		return array(
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'ModelParam',
				'message'    => array('success'=>'模型参数删除成功！'),
				'redirectTo' => 'admin/mparam/index',
				'redirectParam' => array('model_id'=>(int)$_GET['model_id'])
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'ModelParam',
				'redirectTo' => 'admin/mparam/index',
				'redirectParam' => array('model_id'=>(int)$_GET['model_id'])
			),
		);
	}
	
	private function __ModelInfo(){
		if(!isset($_GET['model_id'])&&empty($_GET['model_id'])){
			throw new CHttpException(404,'模型信息不存在');
		}
		Yii::app()->cacheManage->cacheName='ModelCache';
		$model_cache=Yii::app()->cacheManage->findCache();
		if(empty($model_cache[$_GET['model_id']])){
			throw new CHttpException(404,'模型信息不存在');
		}
		$model_data=$model_cache[$_GET['model_id']];
		$tmp_sub_nav=array();
		foreach ($this->sub_nav as $v){
			$v['data']=str_replace('{$model_id}', $_GET['model_id'], $v['data']);
			$tmp_sub_nav[]=$v;
		}
		if(!empty($this->menu_add))$this->menu_add['data']=str_replace('{$model_id}', $_GET['model_id'], $this->menu_add['data']);
		$this->sub_nav=$tmp_sub_nav;
		return $model_data;
	}
	
	public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}

}