<?php

class AccessController extends AdminController
{
	public function actionSetting()
	{
		$auth=Yii::app()->authManager;
		$data['tasks']=$auth->getTasks();
		if(isset($_POST['access'])){
			foreach ($_POST['access'] as $k=>$v){
				$bizrule=empty($v['bizrule'])?null:$v['bizrule'];
				$data=empty($v['data'])?null:$v['data'];
				$tmp_access=$auth->getAuthItem($k);
				$auth->saveAuthItem(new CAuthItem($auth, $k, $tmp_access->type,$tmp_access->description,$bizrule,$data),$k);
			}
			$this->redirectMessage("权限参数设置成功！", Yii::app()->createUrl($this->redirect_url.'setting'),'success');
		}
		$this->render('setting',$data);
	}
	
	public function filters(){
		return array(
			'accessControl',
		);
	}
	
	public function accessRules(){
		return array(
			array('allow',
				'users'=>array('@'),
				'expression'=>Yii::app()->user->is_default,
			),
			array('deny',
				'users'=>array('*')
			),
		);
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}

}