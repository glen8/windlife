<?php
class ColumnCustomUpdateAction extends CAction{
	
	public $module='content';
	
	public $message=array();
	
	public $redirectTo='';
	
	public function run(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$column_info=Column::model()->findByPk((int)$_GET['id']);
		if($column_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.columnCustomForm');
		$form['base']->model=$column_info;
		$form['base']->elements['parentid']->attributes=array('disabled'=>'disabled');
		$column_param=new ColumnParamForm();
		$column_param->attributes=unserialize($column_info->urlparam);
		$form['param']->model=$column_param;
		$column_seo=new ColumnSeoForm();
		$column_seo->attributes=unserialize($column_info->setting);
		$form['seo']->model=$column_seo;
		$data['form']=$form;
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('column_custom_form_button') && $form->validate()){
			$column_info->attributes=$form['base']->model->attributes;
			$column_info->letter=Util::pinyin($column_info->colname);
			$column_info->setting=serialize($form['seo']->model->attributes);
			$column_info->urlparam=serialize($form['param']->model->attributes);
			$urlparam=$form['param']->model->attributes;
			$column_url=empty($urlparam['module'])? $urlparam['c'].'/'.$urlparam['a']:$urlparam['m'].'/'.$urlparam['c'].'/'.$urlparam['a'];
			$column_info->url=empty($urlparam['data'])?Yii::app()->createUrl($column_url):Yii::app()->createUrl($column_url,Util::param2array($urlparam['data']));
			if($column_info->save(false)){
				$this->controller->redirectMessage($this->message['success'], Yii::app()->createUrl($this->redirectTo),'success');
			}
		}
		$this->controller->render('application.modules.admin.components.views.column.customUpdate', $data);
	}
}

?>