<?php

class UrlManager extends CUrlManager {
	
	public function init(){
		$this->getRules();
		parent::init();
	}
	
	protected function getRules(){
		Yii::app()->cacheManage->cacheName='UrlruleCache';
		$urlrule_cache=Yii::app()->cacheManage->findCache();
		$urlrule_array=array();
		foreach ($urlrule_cache as $v){
			$module=isset(Yii::app ()->controller->module->id)?Yii::app ()->controller->module->id:'无模块';
			if($v['module']==$module){			    
			    if(!empty($v['page_rule'])&&!empty($v['page_rule_url'])){
				    $urlrule_array[$v['page_rule']]=$v['page_rule_url'];
			    }
			    $urlrule_array[$v['rule']]=$v['rule_url'];
			}
		}
		$this->rules=CMap::mergeArray($this->rules, $urlrule_array);
	}	
}

?>