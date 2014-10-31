<?php

class AttachmentController extends AdminController
{
	public function actionIndex()
	{		
		$search_model=new Attachment('search');
		$criteria = new CDbCriteria();
		$url_args=array();
		if(isset($_GET['Attachment'])){
			$search_model->attributes=$_GET['Attachment'];
			if(!empty($_GET['Attachment']['filename'])){
				$url_args['filename']=$_GET['Attachment']['filename'];
				$criteria->addSearchCondition('filename', $_GET['Attachment']['filename']);
			}
			if(!empty($_GET['Attachment']['search_begintime'])){
				$url_args['search_begintime']=$_GET['Attachment']['search_begintime'];
				$search_model->search_begintime=$_GET['Attachment']['search_begintime'];
				$criteria->addCondition('uploadtime>=' . strtotime($_GET['Attachment']['search_begintime']));
			}
			if(!empty($_GET['Attachment']['search_endtime'])){
				$url_args['search_endtime']=$_GET['Attachment']['search_endtime'];
				$search_model->search_endtime=$_GET['Attachment']['search_endtime'];				
				$criteria->addCondition('uploadtime<=' . strtotime($_GET['Attachment']['search_endtime']));
			}
			if(!empty($_GET['Attachment']['status'])){
				$url_args['status']=$_GET['Attachment']['status'];
				$criteria->addSearchCondition('status', $_GET['Attachment']['status']);
			}
		}
		else{
			if(!empty($_GET['filename'])){
				$url_args['filename']=$_GET['filename'];
				$search_model->filename=$_GET['filename'];
				$criteria->addSearchCondition('filename', $_GET['filename']);
			}
			if(!empty($_GET['search_begintime'])){
				$url_args['search_begintime']=$_GET['search_begintime'];
				$search_model->search_begintime=$_GET['search_begintime'];
				$criteria->addCondition('uploadtime>=' . strtotime($_GET['search_begintime']));
			}
			if(!empty($_GET['search_endtime'])){
				$url_args['search_endtime']=$_GET['search_endtime'];
				$search_model->search_endtime=$_GET['search_endtime'];
				$criteria->addCondition('uploadtime<=' . strtotime($_GET['search_endtime']));
			}
			if(!empty($_GET['status'])){
				$url_args['status']=$_GET['status'];
				$search_model->status=$_GET['status'];
				$criteria->addSearchCondition('status', $_GET['status']);
			}
		}
		$criteria->order='uploadtime DESC';
		$count=Attachment::model()->count($criteria);
		$pages=new CPagination($count);
		if(!empty($url_args)){
			$pages->params=$url_args;
		}
		$pages->pageSize=12;
		$pages->applyLimit($criteria);
		$models = Attachment::model()->findAll($criteria);
		$this->render('index', array('models' => $models, 'search_model'=>$search_model, 'pages' => $pages));		
	}
	
	public function actions(){
		return array(
			'delete'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Attachment',
				'message'    => array('success'=>'文件删除成功！','warning_biz'=>'文件已用，无法删除'),
				'redirectTo' => 'admin/attachment/index',
				'bizrule'    => '$is_judge=$model->status==1;',
			),
			'deleteAll'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAllAction',
				'modelClass' => 'Attachment',
				'message'    => array('success'=>'文件删除成功！','warning_biz'=>'删除文件中存在已用的，尚未全部删除'),
				'redirectTo' => 'admin/attachment/index',
				'bizrule'    => '$is_judge=$model->status==1;',
			),
		);
	}

	public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
}