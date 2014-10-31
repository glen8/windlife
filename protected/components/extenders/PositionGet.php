<?php

class PositionGet extends CComponent
{	
	public function init(){}
	
	public static function get($key,$position){
		if($position=='1'){
			Yii::app()->cacheManage->cacheName='AdvertCache';
			$advert_cache=Yii::app()->cacheManage->findCache();
			if(!isset($advert_cache[$key]))return '';
			$advert_data=$advert_cache[$key];
			$ad_key=$advert_data['ad_key'];
			$class_name=ucfirst($ad_key);
			$ad_object=$ad_key.'Ad';
			Yii::app()->setComponent($ad_object, array('class'=>'application.extensions.wl_advert.'.$ad_key.'.'.$class_name,'setting'=>$advert_data));
			return Yii::app()->$ad_object->getCode();
		}
		if($position=='0'){
			Yii::app()->cacheManage->cacheName='ReleaseCache';
			$release_cache=Yii::app()->cacheManage->findCache();
			return isset($release_cache[$key])?$release_cache[$key]:array();
		}
		return '';
	}
}