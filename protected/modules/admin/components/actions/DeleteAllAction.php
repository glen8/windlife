<?php
class DeleteAllAction extends CAction {
	
	public $param = 'ids';
	public $modelClass;
	public $message=array('success'=>'删除成功！');
	public $redirectTo;
	public $bizrule;
	public $redirectParam = array();
	
	
	function run() {
		if(!Yii::app()->request->isPostRequest){
			throw new CHttpException ( 400 , '删除需要POST提交');
		}
		$pk = Yii::app ()->request->getParam ( $this->param );
		if (empty ( $pk )){
			throw new CHttpException ( 404 , '信息不存在');
		}
		$url=!empty($this->redirectParam)?Yii::app()->createUrl($this->redirectTo,$this->redirectParam):Yii::app()->createUrl($this->redirectTo);
		$is_all=true;
		foreach ($pk as $id){
			if($id<1)continue;
			$model = AdminBaseModel::model ( $this->modelClass )->findByPk ( (int)$id );
			if (! $model) continue;
			if(!empty($this->bizrule)){
				eval($this->bizrule);
			}
			if(isset($is_judge)&&$is_judge) {$is_all=false;continue;}
			$model->delete();
		}
		if($is_all){
			$this->controller->redirectMessage($this->message['success'], $url,'success');				
		}
		else{
			$this->controller->redirectMessage($this->message['warning_biz'], $url,'warning');
		}		
		throw new CHttpException ( 500 ,'系统错误');
	}
}

?>