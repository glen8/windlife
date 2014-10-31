<?php

class ColumnCustomAction extends CAction{
	
	public $module='content';
	
	public $message=array();
	
	public $redirectTo='';
	
	public function run(){
		$form=new CForm('application.modules.admin.components.forms.columnCustomForm');
		$column=new Column();
		$form['base']->model=$column;
		if(isset($_GET['parent_id'])&&(int)$_GET['parent_id']>0){
			$form['base']->model->parentid=(int)$_GET['parent_id'];
		}
		$form['param']->model=new ColumnParamForm();
		$form['seo']->model=new ColumnSeoForm();
		$data['form']=$form;
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('column_custom_form_button') && $form->validate()){
			$column->attributes=$form['base']->model->attributes;
			$column->module=$this->module;
			$column->arrparentid='0';
			$column->arrchildid='0';
			$column->type='2';
			$column->letter=Util::pinyin($column->colname);
			$column->setting=serialize($form['seo']->model->attributes);
			$column->urlparam=serialize($form['param']->model->attributes);
			$urlparam=$form['param']->model->attributes;
			$column_url=empty($urlparam['module'])? $urlparam['c'].'/'.$urlparam['a']:$urlparam['m'].'/'.$urlparam['c'].'/'.$urlparam['a'];
			$column->url=empty($urlparam['data'])?Yii::app()->createUrl($column_url):Yii::app()->createUrl($column_url,Util::param2array($urlparam['data']));
			if($column->save(false)){
				$this->controller->redirectMessage($this->message['success'], Yii::app()->createUrl($this->redirectTo),'success');
			}
		}
		$this->controller->render('application.modules.admin.components.views.column.custom',$data);
	}
}

?>