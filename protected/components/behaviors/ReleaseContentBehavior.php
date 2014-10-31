<?php

class ReleaseContentBehavior extends CActiveRecordBehavior{
	
	public function afterSave($event){		
		if(!$this->owner->isNewRecord){
			$rcs=ReleaseContent::model()->findAllByAttributes(array('model_id'=>$this->owner->model_id,'data_id'=>$this->owner->id));
			foreach ($rcs as $rc){
				$rc->delete();
			}
		}
		if(!empty($this->owner->release_content)){
			Yii::app()->cacheManage->cacheName='ModelCache';
			$model_cache=Yii::app()->cacheManage->findCache();
			$model_info=$model_cache[$this->owner->model_id];
			$url_str=!empty($model_info['module'])?$model_info['module'].'/'.$model_info['controller'].'/view':$model_info['controller'].'/view';
			foreach ($this->owner->release_content as $k=>$v){
				$release_content=new ReleaseContent();
				$release_content->release_id=$v;
				$release_content->model_id=$this->owner->model_id;
				$release_content->column_id=$this->owner->column_id;
				$release_content->data_id=$this->owner->id;
				$release_content->title=$this->owner->title;
				$release_content->description=$this->owner->description;
				$release_content->thumb=$this->owner->thumb;
				$release_content->status=$this->owner->status;
				$release_content->url=Yii::app()->createUrl($url_str,array('id'=>$this->owner->id));
				$release_content->ctime=!empty($this->updatetime)?$this->owner->updatetime:$this->owner->inputtime;
				$release_content->save(false);
			}
		}
		return parent::afterSave($event);
	}
	
	public function afterDelete($event){
	    $rcs=ReleaseContent::model()->findAllByAttributes(array('model_id'=>$this->owner->model_id,'data_id'=>$this->owner->id));
		foreach ($rcs as $rc){
			$rc->delete();
		}
		return parent::afterDelete($event);
	}
}

?>