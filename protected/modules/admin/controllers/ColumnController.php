<?php

class ColumnController extends AdminController
{
	
	public function actions(){
		return array(
			'index'=>array(
				'class'=>'application.modules.admin.components.actions.ColumnIndexAction',
				'module'=>'content',
			),
			'create'=>array(
				'class'=>'application.modules.admin.components.actions.ColumnCreateAction',
				'module'=>'content',
				'message'  => array('success'=>'栏目添加成功！'),
				'redirectTo' => 'admin/column/index',
			),
			'custom'=>array(
				'class'=>'application.modules.admin.components.actions.ColumnCustomAction',
				'module'=>'content',
				'message'  => array('success'=>'自定栏目保存成功！'),
				'redirectTo' => 'admin/column/index',
			),
			'link'=>array(
				'class'=>'application.modules.admin.components.actions.ColumnLinkAction',
				'module'=>'content',
				'message'  => array('success'=>'外部链接栏目保存成功！'),
				'redirectTo' => 'admin/column/index',
			),
			'update'=>array(
				'class'=>'application.modules.admin.components.actions.ColumnUpdateAction',
				'module'=>'content',
				'message'  => array('success'=>'栏目修改成功！'),
				'redirectTo' => 'admin/column/index',
			),
			'customUpdate'=>array(
				'class'=>'application.modules.admin.components.actions.ColumnCustomUpdateAction',
				'module'=>'content',
				'message'  => array('success'=>'自定栏目修改成功！'),
				'redirectTo' => 'admin/column/index',
			),
			'linkUpdate'=>array(
				'class'=>'application.modules.admin.components.actions.ColumnLinkUpdateAction',
				'module'=>'content',
				'message'  => array('success'=>'外部链接栏目修改成功！'),
				'redirectTo' => 'admin/column/index',
			),
			'imageManager'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageManager',
			),
			'imageUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageUp',
			),
			'remoteImage'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.RemoteImage',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'Column',
				'redirectTo' => 'admin/column/index',
			),
		);
	}	
	
	
	public function actionParam(){
		if(empty($_GET['column_id'])||empty($_GET['model_id'])){
			throw new CHttpException ( 404 , '参数错误');
		}
		$model_params=ModelParam::model()->order('listorder ASC,id DESC')->findAll('model_id=:model_id',array('model_id'=>(int)$_GET['model_id']));
		$data['models']=$model_params;
		$column_param=ColumnParam::model()->find('column_id=:column_id AND model_id=:model_id',array('column_id'=>(int)$_GET['column_id'],'model_id'=>$_GET['model_id']));
		if($column_param!==null){
			$data['params']=unserialize($column_param->value);
		}
		if(isset($_POST['param'])){
			$param_array=array();
			foreach ($model_params as $v){
				$param_array[$v->position][$v->key]=$_POST['param'][$v->id];
			}
			if(count($param_array)>0){
				$column_param=isset($column_param)&&$column_param!==null?$column_param:new ColumnParam();
				$column_param->column_id=(int)$_GET['column_id'];
				$column_param->model_id=(int)$_GET['model_id'];
				$column_param->value=serialize($param_array);
				if($column_param->save(false)){
					$this->redirectMessage("栏目参数设置成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
				}
			}
		}
		$this->render('application.modules.admin.components.views.column.param',$data);
	}
	
	public function actionDelete(){
		if(!Yii::app()->request->isPostRequest){
			throw new CHttpException ( 400 , '删除需要POST提交');
		}
		$pk = Yii::app ()->request->getParam ( 'id' );
		if (empty ( $pk )){
			throw new CHttpException ( 404 , '信息不存在');
		}
		$model=Column::model()->findByPk((int)$pk);
		if (! $model){
			throw new CHttpException ( 404 , '信息不存在' );
		}		
		if($model->child==1){
			$this->redirectMessage('存在子栏目，无法删除', Yii::app()->createUrl($this->redirect_url.'index'),'warning');
		}
		Yii::app()->cacheManage->cacheName='ModelCache';
		$model_cache=Yii::app()->cacheManage->findCache();
		if($model->type==1&&!empty($model_cache[$model->modelid])){
			if($model_cache[$model->modelid]['data_num']==1&&$model->items>0){
				$this->redirectMessage('此栏目存在数据，无法删除', Yii::app()->createUrl($this->redirect_url.'index'),'warning');
			}
		}
		if ($model->delete ()){
			$this->redirectMessage('栏目删除成功', Yii::app()->createUrl($this->redirect_url.'index'),'success');
		}
		throw new CHttpException ( 500 ,'系统错误');
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
}