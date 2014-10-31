<?php

class SettingGet extends CComponent
{
	
	public function init(){}
	
	public static function get($key,$field){
		Yii::app()->cacheManage->cacheName='SettingCache';
		$setting=Yii::app()->cacheManage->findCache();
		if(isset($setting[$key])){
			$setting_key_value=unserialize($setting[$key]['value']);
			if(isset($setting_key_value[$field])){
				return $setting_key_value[$field];
			}
		}
		return '';
	}
}