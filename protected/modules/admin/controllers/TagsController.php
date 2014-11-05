<?php

class TagsController extends adminController
{
	public function actionIndex()
	{
		$data['models']=Tags::model()->findAll();
		$this->render('index',$data);
	}
	
	public function actionCreate(){
	    if(!Yii::app()->request->isAjaxRequest){
	        echo '0';
	        Yii::app()->end();
	    }
	    if(!isset($_POST['tags_str'])||empty($_POST['tags_str'])){
	        echo '0';
	        Yii::app()->end();
	    }
	    $tags_array=explode(',', $_POST['tags_str']);
	    $tag_return=array();
	    $tags_array=array_filter($tags_array);
	    foreach ($tags_array as $k=>$v){
	        $tags=Tags::model()->findByAttributes(array('title'=>$v));
	        if($tags===null){
	            $tags=new Tags();
	            $tags->title=$v;
	            $tags->post_id=Yii::app()->user->id;	
	            $tags->save(false);       
	        }
	        $tag_return[$k]=$tags->attributes;
	    }
	    echo json_encode($tag_return);
	}

	public function actions(){
		return array(
			'delete'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Tags',
				'message'    => array('success'=>'标签删除成功！'),
				'redirectTo' => 'admin/tags/index',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'Tags',
				'redirectTo' => 'admin/tags/index',
			),
		);
	}


	public function beforeAction($action){
	    $this->wl_accessControl();
	    return parent::beforeAction($action);
	}
	
	
}