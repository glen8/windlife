<?php

class UpdateObjectItemsBehavior extends CActiveRecordBehavior{
	
	public function afterSave($event){
		if($this->owner->getIsNewRecord()){
			if(!empty($this->owner->column_id)&&!empty($this->owner->model_id)){
				Yii::app()->db->createCommand()->update('{{column}}', array('items'=>new CDbExpression('items+1')),'id=:id',array(':id'=>$this->owner->column_id));
				Yii::app()->db->createCommand()->update('{{model_object}}', array('items'=>new CDbExpression('items+1')),'id=:id',array(':id'=>$this->owner->model_id));
			}
		}
		return parent::afterSave($event);
	}
	
	public function afterDelete($event){
		if(!empty($this->owner->column_id)&&!empty($this->owner->model_id)){
			Yii::app()->db->createCommand()->update('{{column}}', array('items'=>new CDbExpression('items-1')),'items>0 and id=:id',array(':id'=>$this->owner->column_id));
			Yii::app()->db->createCommand()->update('{{model_object}}', array('items'=>new CDbExpression('items-1')),'items>0 and id=:id',array(':id'=>$this->owner->model_id));
		}
		return parent::afterDelete($event);
	}
	
}

?>