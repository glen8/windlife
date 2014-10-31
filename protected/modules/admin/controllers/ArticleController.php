<?php

class ArticleController extends AdminController
{
	
	public $bady_class;
	
	public function actionIndex(){
		$column_info=$this->__columnInfo();
		$search_model=new Article('search');
		$criteria = new CDbCriteria();
		$criteria->addCondition('column_id=' . (int)$_GET['column_id']);
		$url_args=array();
		$url_args['column_id']=(int)$_GET['column_id'];
		if(isset($_GET['Article'])){
			$search_model->attributes=$_GET['Article'];
			if(!empty($_GET['Article']['search_value'])){
				$search_model->search_value=$url_args['search_value']=$_GET['Article']['search_value'];
				$search_model->search_field=$url_args['search_field']=$_GET['Article']['search_field'];
				$criteria->addSearchCondition($search_model->search_field, $_GET['Article']['search_value']);
			}
			if(!empty($_GET['Article']['search_begintime'])){
				$search_model->search_begintime=$url_args['search_begintime']=$_GET['Article']['search_begintime'];
				$criteria->addCondition('inputtime>='.new CDbExpression("str_to_date('{$search_model->search_begintime} 00:00:01','%Y-%m-%d %H:%i:%s')"));
			}
	 		if(!empty($_GET['Article']['search_endtime'])){
				$search_model->search_endtime=$url_args['search_endtime']=$_GET['Article']['search_endtime'];
                $criteria->addCondition('inputtime<='.new CDbExpression("str_to_date('{$search_model->search_endtime} 23:59:59','%Y-%m-%d %H:%i:%s')"));
			}
		}
		else{
			if(!empty($_GET['search_value'])){
				$search_model->search_value=$url_args['search_value']=$_GET['search_value'];
				$search_model->search_field=$url_args['search_field']=$_GET['search_field'];
				$criteria->addSearchCondition($search_model->search_field, $_GET['search_value']);
			}
						
			if(!empty($_GET['search_begintime'])){
				$search_model->search_begintime=$url_args['search_begintime']=$_GET['search_begintime'];
				$criteria->addCondition('inputtime>='.new CDbExpression("str_to_date('{$search_model->search_begintime} 00:00:01','%Y-%m-%d %H:%i:%s')"));
			}
			if(!empty($_GET['search_endtime'])){
				$search_model->search_endtime=$url_args['search_endtime']=$_GET['search_endtime'];
				$criteria->addCondition('inputtime<='.new CDbExpression("str_to_date('{$search_model->search_endtime} 23:59:59','%Y-%m-%d %H:%i:%s')"));
			}
		}
		$count=Article::model()->count($criteria);
		$pages=new CPagination($count);
		if(!empty($url_args)){
			$pages->params=$url_args;
		}
		$pages->pageSize=12;
		$pages->applyLimit($criteria);
		$models = Article::model()->findAll($criteria);
		$this->render('index',array('column_info'=>$column_info,'models' => $models, 'search_model'=>$search_model, 'pages' => $pages));
	}
	
	public function actionCreate(){
		$this->bady_class='content_create';
		Yii::app()->cacheManage->cacheName='CopyfromCache';
		$copy_from_cache=Yii::app()->cacheManage->findCache();
		$column_info=$this->__columnInfo();
	    $model=new Article();
	    $model->inputtime=date('Y-m-d H:i:s');
	    if(isset($_POST['ajax']) && $_POST['ajax']==='article_form'){
	    	echo CActiveForm::validate($model);
	    	Yii::app()->end();
	    }
	    if(isset($_POST['Article'])){
	    	$model->attributes=$_POST['Article'];
	    	$model->admin_id=Yii::app()->user->id;
	    	$model->column_id=$column_info['id'];
	    	$model->model_id=$column_info['modelid'];
	    	if($model->save()){
	    		if(isset($_POST['open_button'])){
	    			$this->redirectMessage("文章添加保存成功！", Yii::app()->createUrl($this->redirect_url.'create',array('column_id'=>$column_info['id'])),'success',3 ,'<script>setTimeout(\'window.opener.location.reload()\',500);</script>');
	    		}
	    		$this->redirectMessage("文章添加保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.opener.location.reload();window.close()\',500);</script>');
	    	}
	    }
		$this->render('create',array('model'=>$model,'column_info'=>$column_info, 'copy_from_cache'=>$copy_from_cache));
	}
	
	public function actionUpdate(){
		$this->bady_class='content_create';
		Yii::app()->cacheManage->cacheName='CopyfromCache';
		$copy_from_cache=Yii::app()->cacheManage->findCache();
		$column_info=$this->__columnInfo();
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'文章信息不存在');
		}
		$article_info=Article::model()->findByPk((int)$_GET['id']);
		if($article_info===null){
			throw new CHttpException(404,'文章信息不存在');
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='article_form'){
			echo CActiveForm::validate($article_info);
			Yii::app()->end();
		}
		$article_info->updatetime=date('Y-m-d H:i:s');
		if(isset($_POST['Article'])){
			$article_info->attributes=$_POST['Article'];
			if($article_info->save()){
				if(isset($_POST['open_button'])){
					$this->redirectMessage("文章词修改保存成功！", Yii::app()->createUrl($this->redirect_url.'create',array('column_id'=>$column_info['id'])),'success',3 ,'<script>setTimeout(\'window.opener.location.reload()\',500);</script>');
				}
				$this->redirectMessage("文章修改保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.opener.location.reload();window.close()\',500);</script>');
			}
		}
		$this->render('create',array('model'=>$article_info,'column_info'=>$column_info, 'copy_from_cache'=>$copy_from_cache));		
	}
	
	private function __columnInfo(){
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
			$v['data']=str_replace('{$column_id}', $_GET['column_id'], $v['data']);
			$tmp_sub_nav[]=$v;
		}
		if(!empty($this->menu_add))$this->menu_add['data']=str_replace('{$column_id}', $_GET['column_id'], $this->menu_add['data']);
		$this->sub_nav=$tmp_sub_nav;
		$this->breadcrumbs.=' '.$column_data['colname'];
		$this->menu_name=$column_data['colname'];
		$this->menu_url=str_replace('{$column_id}', $_GET['column_id'], urldecode($this->menu_url));
		return $column_data;
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
			'scrawlUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ScrawlUp',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'Article',
				'redirectTo' => 'admin/article/index',
				'redirectParam' => array('column_id'=>isset($_GET['column_id'])?(int)$_GET['column_id']:0)
			),
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'article',
				'message'    => array('success'=>'删除成功！'),
				'redirectTo' => 'admin/article/index',
				'redirectParam' => array('column_id'=>isset($_GET['column_id'])?(int)$_GET['column_id']:0)
			),
			'deleteAll'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAllAction',
				'modelClass' => 'Article',
				'message'    => array('success'=>'文章删除成功！'),
				'redirectTo' => 'admin/article/index',
				'redirectParam' => array('column_id'=>isset($_GET['column_id'])?(int)$_GET['column_id']:0)
			),
		);
	}
	
	public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
}