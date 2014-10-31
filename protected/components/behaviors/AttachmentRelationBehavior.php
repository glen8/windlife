<?php

class AttachmentRelationBehavior extends CActiveRecordBehavior{
	
	public $modelName;
	
	public $attributes =array();
	
	public function beforeSave($event){
		if(!$this->owner->getIsNewRecord()){
			$this->__deleteRelation();
		}
		return parent::beforeSave($event);
	}
	
	public function afterSave($event){
		Yii::app()->cacheManage->cacheName='SettingCache';
		$setting_cache=Yii::app()->cacheManage->findCache();
		$setting_upload=unserialize($setting_cache['upload']['value']);
		$atta_array=array();
		foreach($this->attributes as $attribute=>$v){
			if($v){
				preg_match_all ( "/\/uploadfiles(.*).({$setting_upload['fileType']})/isU", stripslashes($this->getOwner()->{$attribute}), $tmp_array );
				$atta_array=array_merge($atta_array,$tmp_array[0]);
			}
			else{
				$atta_array[]=$this->getOwner()->{$attribute};
			}
		}
		$atta_array=array_unique($atta_array);
		$multiple_array=array();
		foreach ($atta_array as $k=>$atta){
			$row=Yii::app()->db->createCommand()->select('id')->from('{{attachment}}')->where('filepath=:filepath',array(':filepath'=>'.'.$atta))->query()->read();
			if(!$row)continue;
			Yii::app()->db->createCommand()->update('{{attachment}}', array('status'=>1),'id=:id',array(':id'=>$row['id']));
			$multiple_array[$k]['model_name']=$this->modelName;
			$multiple_array[$k]['attachment_id']=$row['id'];
			$multiple_array[$k]['record_id']=$this->owner->id;
		}
		if(count($multiple_array)>0){
			$builder=Yii::app()->db->schema->commandBuilder;
			$command=$builder->createMultipleInsertCommand('{{attachment_item}}', $multiple_array);
			$command->execute();
		}
		return parent::afterSave($event);
	}
	
	public function afterDelete($event){
		$this->__deleteRelation();
		return parent::afterDelete($event);
	}

	private function __deleteRelation(){
		$rows=Yii::app()->db->createCommand()->select('attachment_id')->from('{{attachment_item}}')->where('model_name=:model_name and record_id=:record_id',array(':model_name'=>$this->modelName,':record_id'=>$this->owner->id))->query()->readAll();
		Yii::app()->db->createCommand()->delete('{{attachment_item}}','model_name=:model_name and record_id=:record_id',array(':model_name'=>$this->modelName,':record_id'=>$this->owner->id));
		foreach ($rows as $row){
			$status_row=Yii::app()->db->createCommand()->select('id')->from('{{attachment_item}}')->where('attachment_id=:attachment_id',array(':attachment_id'=>$row['attachment_id']))->query()->read();
			if($status_row) continue;
			Yii::app()->db->createCommand()->update('{{attachment}}', array('status'=>0),'id=:id',array(':id'=>$row['attachment_id']));
		}
	}
	
}

?>