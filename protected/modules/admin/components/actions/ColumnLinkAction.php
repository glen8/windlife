<?php

class ColumnLinkAction extends CAction{
	
	public $module='content';	
	
	public $message=array();
	
	public $redirectTo='';
	
	public function run(){
		$form=new CForm('application.modules.admin.components.forms.columnLinkForm');
		$column=new Column();
		$column->scenario='link';
		$form['base']->model=$column;
		if(isset($_GET['parent_id'])&&(int)$_GET['parent_id']>0){
			$form['base']->model->parentid=(int)$_GET['parent_id'];
		}
		$data['form']=$form;
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('column_link_form_button') && $form->validate()){
			$column->attributes=$form['base']->model->attributes;
			$column->module=$this->module;
			$column->arrparentid='0';
			$column->arrchildid='0';
			$column->type='3';
			$column->letter=Util::pinyin($column->colname);
			$column->setting='';
			if($column->save(false)){
				$this->controller->redirectMessage($this->message['success'], Yii::app()->createUrl($this->redirectTo),'success');
			}
		}
		$this->controller->render('application.modules.admin.components.views.column.link',$data);
	}
	
}

?>