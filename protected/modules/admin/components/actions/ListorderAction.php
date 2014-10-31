<?php

class ListorderAction extends CAction{
	
	public $param = 'listorders';
	public $modelClass;
	public $message=array('success'=>'操作成功！');
	public $redirectTo;
	public $redirectParam = array();
	
	function run() {
		$listorders = Yii::app ()->request->getParam ( $this->param );
		if (empty ( $listorders )||count($listorders)<1){
			throw new CHttpException ( 404 );
		}
		$url=!empty($this->redirectParam)?Yii::app()->createUrl($this->redirectTo,$this->redirectParam):Yii::app()->createUrl($this->redirectTo);
		foreach ($_POST['listorders'] as $k=>$v){
			$model=AdminBaseModel::model($this->modelClass)->findByPk($k);
			$model->listorder=$v;
			$model->save();
		}
		$this->controller->redirectMessage($this->message['success'], $url,'success');
	}
	
}

?>