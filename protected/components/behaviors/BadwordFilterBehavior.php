<?php

class BadwordFilterBehavior extends CActiveRecordBehavior{
	
	public $attributes =array();
	
	public function beforeSave($event){
		Yii::app()->cacheManage->cacheName='BadwordCache';
		$bardword_cache=Yii::app()->cacheManage->findCache();
		foreach($this->attributes as $attribute){
			$this->getOwner()->{$attribute} = str_replace($bardword_cache['search_array'], $bardword_cache['replace_array'], $this->getOwner()->{$attribute});
		}
		return parent::beforeSave($event);
	}
}

?>