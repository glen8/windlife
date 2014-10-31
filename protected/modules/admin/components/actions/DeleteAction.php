<?php
class DeleteAction extends CAction {
	
	public $param = 'id';
	public $modelClass;
	public $message=array('success'=>'删除成功！');
	public $redirectTo;
	public $isHasChild = array ();
	public $redirectParam = array();
	
	public $bizrule;
	
	function run() {
		if(!Yii::app()->request->isPostRequest){
			throw new CHttpException ( 400 , '删除需要POST提交');
		}
		$pk = Yii::app ()->request->getParam ( $this->param );
		if (empty ( $pk )){
			throw new CHttpException ( 404 , '信息不存在');
		}
		
		$model = AdminBaseModel::model ( $this->modelClass )->findByPk ( (int)$pk );
		if (! $model){
			throw new CHttpException ( 404 , '信息不存在' );
		}	
		
		$url=!empty($this->redirectParam)?Yii::app()->createUrl($this->redirectTo,$this->redirectParam):Yii::app()->createUrl($this->redirectTo);
		
		if(!empty($this->isHasChild))	{
		    $child_count=AdminBaseModel::model($this->isHasChild['ChildModelClass'])->countByAttributes(array($this->isHasChild['ChildModelField']=>(int)$pk));
		    if($child_count>0){
			    $this->controller->redirectMessage($this->message['warning_child'], $url,'warning');
		    }
		}		
		
		if(!empty($this->bizrule)){
			eval($this->bizrule);
		}
		
		if(isset($is_judge)&&$is_judge){
			$this->controller->redirectMessage($this->message['warning_biz'], $url,'warning');
		}		
		
		if ($model->delete ()){
			$this->controller->redirectMessage($this->message['success'], $url,'success');
		}
	
		throw new CHttpException ( 500 ,'系统错误');
	}
}

?>