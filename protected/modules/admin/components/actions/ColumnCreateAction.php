<?php
class ColumnCreateAction extends CAction{
	
	public $module='content';
	
	public $message=array();
	
	public $redirectTo='';
	
	public function run(){
		$form=new CForm('application.modules.admin.components.forms.columnModelForm');
		$column=new Column();	
		$column->scenario='base';	
		$form['base']->model=$column;
		if(isset($_GET['parent_id'])&&(int)$_GET['parent_id']>0){
			$form['base']->model->parentid=(int)$_GET['parent_id'];
		}
		$form['seo']->model=new ColumnSeoForm();
		$data['form']=$form;
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('column_model_form_button') && $form->validate()){
			$column->attributes=$form['base']->model->attributes;
			$column->module=$this->module;
			$column->arrparentid='0';
			$column->arrchildid='0';
			$column->type='1';
			Yii::app()->cacheManage->cacheName='ModelCache';
			$model_cache=Yii::app()->cacheManage->findCache();
			$model_now=$model_cache[$column->modelid];
			$column_url=empty($model_now['module'])? $model_now['controller'].'/'.$model_now['action']:$model_now['module'].'/'.$model_now['controller'].'/'.$model_now['action'];
			$column->url=empty($model_now['data'])?Yii::app()->createUrl($column_url,array('keyparam'=>$column->keyparam)):Yii::app()->createUrl($column_url,CMap::mergeArray(Util::param2array($model_now['data']),array('keyparam'=>$column->keyparam)));
			$column->letter=Util::pinyin($column->colname);
			$column->setting=serialize($form['seo']->model->attributes);
			if($column->save(false)){
				$this->controller->redirectMessage($this->message['success'], Yii::app()->createUrl($this->redirectTo),'success');
			}
		}
		$this->controller->render('application.modules.admin.components.views.column.create',$data);
	}
}

?>