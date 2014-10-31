<?php
class ColumnDeleteAction extends CAction {
	
	public $param = 'id';
	public $modelClass;
	public $message=array('success'=>'删除成功！');
	public $redirectTo;
	
	function run() {
		$pk = Yii::app ()->request->getParam ( $this->param );
		if (empty ( $pk )){
			throw new CHttpException ( 404 );
		}
		
		$model = BaseModel::model ( $this->modelClass )->findByPk ( (int)$pk );
		if (! $model){
			throw new CHttpException ( 404 );
		}	
		
		if($model->child)	{
		    $this->controller->redirectMessage($this->message['warning1'], Yii::app()->createUrl($this->redirectTo),'warning');
		}
		
		if($model->items>0)	{
			$this->controller->redirectMessage($this->message['warning2'], Yii::app()->createUrl($this->redirectTo),'warning');
		}
		
		if ($model->delete ()){
			$this->controller->redirectMessage($this->message['success'], Yii::app()->createUrl($this->redirectTo),'success');
		}
		
		throw new CHttpException ( 500 );
	}
}

?>