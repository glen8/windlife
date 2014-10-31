<?php
class ReleaseCon extends CInputWidget{
	
	// html 选项
	public $htmlOptions = array ();
	//模型id
	public $model_id;
	
	public function run(){		
		list ( $name, $id ) = $this->resolveNameID ();
		$this->htmlOptions ['id'] = $id;
		$relesase=Release::model()->findAll('model_id=0 OR model_id=:model_id',array('model_id'=>(int)$this->model_id));
		$html='';
		if ($this->hasModel ()) {
			if(!empty($this->model->id)){
				$rc=ReleaseContent::model()->findAll('model_id=:model_id AND data_id=:data_id',array('model_id'=>(int)$this->model_id,'data_id'=>$this->model->id));
				$selected_array=array();
				foreach ($rc as $v){
					$selected_array[]=$v->release_id;
				}
				$field=$this->attribute;
				$this->model->$field=$selected_array;
			}
			$html .= CHtml::activeCheckBoxList($this->model, $this->attribute, CHtml::listData($relesase, 'id', 'title'), $this->htmlOptions);
		} else {
			$html .= CHtml::checkBoxList($this->name, $this->select, CHtml::listData($relesase, 'id', 'title'), $this->htmlOptions);
		}			
		echo $html;
		
	}
}
?>