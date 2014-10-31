<?php

class UpdateCacheBehavior extends CActiveRecordBehavior {
	
	public $cacheName;
	
	public $fieldName;
	
	public function afterSave($event){
		if($this->cacheName!==null){			
			Yii::app()->cacheManage->cacheName=$this->cacheName;
			Yii::app()->cacheManage->UpdateCache();
		}
		if($this->fieldName!==null){
			$fileName=$this->fieldName;
			Yii::app()->cacheManage->cacheName=ucfirst($this->owner->$fileName).'Cache';
			Yii::app()->cacheManage->UpdateCache();
		}
		return parent::afterSave($event);
	}
	
	public function afterDelete($event){
		if($this->cacheName!==null){
			Yii::app()->cacheManage->cacheName=$this->cacheName;
			Yii::app()->cacheManage->UpdateCache();
		}
		if($this->fieldName!==null){
			$fileName=$this->fieldName;
			Yii::app()->cacheManage->cacheName=ucfirst($this->owner->$fileName).'Cache';
			Yii::app()->cacheManage->UpdateCache();
		}
		return parent::afterSave($event);
	}
}

?>