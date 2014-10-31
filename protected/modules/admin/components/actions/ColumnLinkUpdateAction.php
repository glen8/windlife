<?php

class ColumnLinkUpdateAction extends CAction{
	
	public $module='content';
	
	public $message=array();
	
	public $redirectTo='';
	
	public function run(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$column_info=Column::model()->findByPk((int)$_GET['id']);
		$column_info->scenario='link';
		if($column_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.columnLinkForm');
		$form['base']->model=$column_info;
		$form['base']->elements['parentid']->attributes=array('disabled'=>'disabled');
		$data['form']=$form;
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:'base';
		if($form->submitted('column_link_form_button') && $form->validate()){
			$column_info->attributes=$form['base']->model->attributes;
			$column_info->letter=Util::pinyin($column_info->colname);
			if($column_info->save(false)){
				$this->controller->redirectMessage($this->message['success'], Yii::app()->createUrl($this->redirectTo),'success');
			}
		}
		$this->controller->render('application.modules.admin.components.views.column.linkUpdate',$data);
	}
	
}

?>