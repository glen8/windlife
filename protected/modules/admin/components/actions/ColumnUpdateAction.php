<?php
class ColumnUpdateAction extends CAction{
	
	public $module='content';
	
	public $message=array();
	
	public $redirectTo='';
	
	public function run(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$column_info=Column::model()->findByPk((int)$_GET['id']);
		$column_info->scenario='base';
		if($column_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.columnModelForm');
		$form['base']->model=$column_info;
		if($column_info->items>0){
		    $form['base']->elements['modelid']->attributes=array('disabled'=>'disabled');
		}
		$form['base']->elements['parentid']->attributes=array('disabled'=>'disabled','prompt'=>'作为一级菜单');
		$column_seo=new ColumnSeoForm();
		$column_seo->attributes=unserialize($column_info->setting);
		$form['seo']->model=$column_seo;
		$data['form']=$form;
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('column_model_form_button') && $form->validate()){
			$column_info->attributes=$form['base']->model->attributes;
			Yii::app()->cacheManage->cacheName='ModelCache';
			$model_cache=Yii::app()->cacheManage->findCache();
			$model_now=$model_cache[$column_info->modelid];
			$column_url=empty($model_now['module'])? $model_now['controller'].'/'.$model_now['action']:$model_now['module'].'/'.$model_now['controller'].'/'.$model_now['action'];
			$column_info->url=empty($model_now['data'])?Yii::app()->createUrl($column_url,array('keyparam'=>$column_info->keyparam)):Yii::app()->createUrl($column_url,CMap::mergeArray(Util::param2array($model_now['data']),array('keyparam'=>$column_info->keyparam)));
			$column_info->letter=Util::pinyin($column_info->colname);
			$column_info->setting=serialize($form['seo']->model->attributes);
			if($column_info->save(false)){
				$this->controller->redirectMessage($this->message['success'], Yii::app()->createUrl($this->redirectTo),'success');
			}
		}
		$this->controller->render('application.modules.admin.components.views.column.update',$data);
	}
}

?>