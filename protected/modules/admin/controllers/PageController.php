<?php

class PageController extends AdminController
{
	public function actionEdit(){
	    if(!isset($_GET['column_id'])&&empty($_GET['column_id'])){
			throw new CHttpException(404,'栏目信息不存在');
		}
		Yii::app()->cacheManage->cacheName='ContentCache';
		$content_cache=Yii::app()->cacheManage->findCache();
		if(empty($content_cache[$_GET['column_id']])){
			throw new CHttpException(404,'栏目信息不存在');
		}
		$column_data=$content_cache[$_GET['column_id']];
		$tmp_sub_nav=array();
		foreach ($this->sub_nav as $v){
			if($v['a']=='edit'){
				$v['data']=str_replace('{$column_id}', $_GET['column_id'], $v['data']);
			}
			$tmp_sub_nav[]=$v;
		}	
		$this->sub_nav=$tmp_sub_nav;
		$this->breadcrumbs.=' '.$column_data['colname'];
		$this->menu_name=$column_data['colname'];		
		$this->menu_url=str_replace('{$column_id}', $_GET['column_id'], urldecode($this->menu_url));
		$page_info=Page::model()->findByAttributes(array('column_id'=>(int)$_GET['column_id']));
		$form=new CForm('application.modules.admin.components.forms.pageForm');
		$form['page']->model=$page_info?$page_info:new Page();
		$form['page']->elements['title']->maxLength=ParamGet::get($column_data['id'], 0, 'b_title_length');
		$form['page']->elements['title']->hint='标题最长 '.ParamGet::get($column_data['id'], 0, 'b_title_length').' 字符';
		if(isset($_POST['ajax']) && $_POST['ajax']==='page_form'){
			echo CActiveForm::validate($form['page']->model);
			Yii::app()->end();
		}
		if($form->submitted('page_form_button') && $form->validate()){
			$page=$form['page']->model;
			$page->column_id=(int)$_GET['column_id'];
			$page->model_id=$column_data['modelid'];
			$page->admin_id=Yii::app()->user->id;
			if($page->save(false)){
				$this->redirectMessage("栏目信息保存成功！", Yii::app()->createUrl($this->redirect_url.'edit',array('column_id'=>$_GET['column_id'])),'success');
			}
		}
		$this->render('edit',array('form'=>$form,'label_width'=>'100'));
	}
	
	public function actions(){
		return array(
			'imageManager'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageManager',
			),
			'imageUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageUp',
			),
			'remoteImage'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.RemoteImage',
			),
			'fileUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.FileUp',
			),
			'movie'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.Movie',
			),
			'scrawlUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ScrawlUp',
			),
		);
	}
	
	public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}

}