<?php

class CacheManage extends CComponent
{
	
	private $cacheName;
	
	public function init(){}
	
	public function setCacheName($cacheName){
		$this->cacheName=$cacheName;
	}
	
	public function getCacheName(){
		return $this->cacheName;
	}
	
	//更新缓存方法
	public function updateCache(){
		if($this->cacheName!==null){
			if(method_exists($this, '_update'.$this->cacheName)){
				call_user_func(array($this,'_update'.$this->cacheName));
			}
		}
	}
	
	//取得缓存方法
	public function findCache(){
		if($this->cacheName!==null){
			$array_cache=Yii::app()->cache->get($this->cacheName);			
            if(empty($array_cache)){            	
            	if(method_exists($this, '_update'.$this->cacheName)){
            		call_user_func(array($this,'_update'.$this->cacheName));
            	}
            	$array_cache=Yii::app()->cache->get($this->cacheName);
            }
            return $array_cache;
		}
	}
	
	//后台管理菜单更新缓存
	private function _updateMenuCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{menu}}')->order('listorder ASC,id ASC');
		$dataReader=$command->query();
		$menu_array=array();
		foreach($dataReader as $row)
		{
			$menu_array[$row['id']]['id']=$row['id'];
			$menu_array[$row['id']]['parentid']=$row['parent_id'];
			$menu_array[$row['id']]['name']=$row['name'];
			$menu_array[$row['id']]['m']=$row['m'];
			$menu_array[$row['id']]['c']=$row['c'];
			$menu_array[$row['id']]['a']=$row['a'];
			$menu_array[$row['id']]['data']=$row['data'];
			$menu_array[$row['id']]['listorder']=$row['listorder'];
			$menu_array[$row['id']]['display']=$row['display'];
			$menu_array[$row['id']]['size']=$row['size'];
		}
		Yii::app()->cache->set($this->cacheName,$menu_array);
	}
	
	//后台模块配置信息更新缓存
	private function _updateModuleCache(){
		
	}	
	
	//网站配置信息更新缓存
	private function _updateSettingCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{setting}}');
		$dataReader=$command->query();
		$setting_array=array();
		foreach($dataReader as $row)
		{
			$setting_array[$row['key']]['key']=$row['key'];
			$setting_array[$row['key']]['name']=$row['name'];
			$setting_array[$row['key']]['value']=$row['value'];
		}
		Yii::app()->cache->set($this->cacheName,$setting_array);
	}
	
	//后台模型信息更新缓存
	private function _updateModelCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{model_object}}');
		$dataReader=$command->query();
		$model_array=array();
		foreach($dataReader as $row)
		{
			$model_array[$row['id']]['id']=$row['id'];
			$model_array[$row['id']]['name']=$row['name'];
			$model_array[$row['id']]['module']=$row['module'];
			$model_array[$row['id']]['controller']=$row['controller'];
			$model_array[$row['id']]['action']=$row['action'];
			$model_array[$row['id']]['data']=$row['data'];
			$model_array[$row['id']]['object']=$row['object'];
			$model_array[$row['id']]['m_module']=$row['m_module'];
			$model_array[$row['id']]['m_controller']=$row['m_controller'];
			$model_array[$row['id']]['m_action']=$row['m_action'];
			$model_array[$row['id']]['m_data']=$row['m_data'];
			$model_array[$row['id']]['data_num']=$row['data_num'];
		}
		Yii::app()->cache->set($this->cacheName,$model_array);
	}	
	
	
	//内容栏目信息更新缓存
	private function _updateContentCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{column}}')->where('module=:module',array('module'=>'content'));
		$dataReader=$command->query();
		$content_array=array();
		foreach($dataReader as $row)
		{
			$content_array[$row['id']]['id']=$row['id'];
			$content_array[$row['id']]['module']=$row['module'];
			$content_array[$row['id']]['type']=$row['type'];
			$content_array[$row['id']]['keyparam']=$row['keyparam'];
			$content_array[$row['id']]['modelid']=$row['modelid'];
			$content_array[$row['id']]['parentid']=$row['parentid'];
			$content_array[$row['id']]['arrparentid']=$row['arrparentid'];
			$content_array[$row['id']]['child']=$row['child'];
			$content_array[$row['id']]['arrchildid']=$row['arrchildid'];
			$content_array[$row['id']]['colname']=$row['colname'];
			$content_array[$row['id']]['image']=$row['image'];
			$content_array[$row['id']]['description']=$row['description'];			
			if($row['type']==1){				
				$command=$connection->createCommand()->select('*')->from('{{model_object}}')->where('id=:id',array('id'=>$row['modelid']));
				$dataReader=$command->query();
				$model_now=$dataReader->read();
				$column_url=empty($model_now['module'])? $model_now['controller'].'/'.$model_now['action']:$model_now['module'].'/'.$model_now['controller'].'/'.$model_now['action'];
				$content_array[$row['id']]['url']=empty($model_now['data'])?Yii::app()->createUrl($column_url,array('keyparam'=>$row['keyparam'])):Yii::app()->createUrl($column_url,CMap::mergeArray(Util::param2array($model_now['data']),array('keyparam'=>$row['keyparam'])));
			}
			elseif ($row['type']==2){
				$urlparam=unserialize($row['urlparam']);
				$column_url=empty($urlparam['module'])? $urlparam['c'].'/'.$urlparam['a']:$urlparam['m'].'/'.$urlparam['c'].'/'.$urlparam['a'];
				$content_array[$row['id']]['url']=empty($urlparam['data'])?Yii::app()->createUrl($column_url):Yii::app()->createUrl($column_url,Util::param2array($urlparam['data']));
			}
			elseif ($row['type']==3){
				$content_array[$row['id']]['url']=$row['url'];
			}			
			$content_array[$row['id']]['urlparam']=$row['urlparam'];
			$content_array[$row['id']]['items']=$row['items'];
			$content_array[$row['id']]['hits']=$row['hits'];
			$content_array[$row['id']]['setting']=$row['setting'];
			$content_array[$row['id']]['listorder']=$row['listorder'];
			$content_array[$row['id']]['display']=$row['display'];
			$content_array[$row['id']]['letter']=$row['letter'];
			$content_array[$row['id']]['target']=$row['target'];
			$content_array[$row['id']]['dataway']=$row['dataway'];
			if($row['dataway']==3){
				$content_array[$row['id']]['datachild']=$this->_getColumDataChildId($row['id']);
			}
			else{
				$content_array[$row['id']]['datachild']=0;
			}			
		}
		Yii::app()->cache->set($this->cacheName,$content_array);
	}
	
	//得到调用第一个子栏目数据的ID
	private function _getColumDataChildId($id){
		$command=Yii::app()->db->createCommand()->select('id,dataway')->from('{{column}}')->where('module=:module and type=1 and parentid=:parentid',array('module'=>'content','parentid'=>(int)$id))->order('listorder ASC,id ASC');
		$rows=$command->query()->readAll();
		if(empty($rows))return 0;
		if($rows[0]['dataway']!==3){
			return $rows[0]['id'];
		}
		else{
			$this->_getColumDataChildId($rows[0]['id']);
		}
	}
	
	
	//后台URL规则更新缓存
	private function _updateUrlruleCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{urlrule}}')->order('listorder ASC,id ASC');
		$dataReader=$command->query();
		$urlrule_array=array();
		foreach($dataReader as $row)
		{
			$urlrule_array[$row['id']]['id']=$row['id'];
			$urlrule_array[$row['id']]['name']=$row['name'];
			$urlrule_array[$row['id']]['module']=$row['module'];
			$urlrule_array[$row['id']]['rule']=$row['rule'];
			$urlrule_array[$row['id']]['rule_url']=$row['rule_url'];
			$urlrule_array[$row['id']]['page_rule']=$row['page_rule'];
			$urlrule_array[$row['id']]['page_rule_url']=$row['page_rule_url'];
			$urlrule_array[$row['id']]['listorder']=$row['listorder'];
		}
		Yii::app()->cache->set($this->cacheName,$urlrule_array);
	}
	
	//更新信息来源记录缓存
	private function _updateCopyfromCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{copyfrom}}')->order('is_default DESC,listorder ASC,id ASC');
		$dataReader=$command->query();
		$copyfrom_array=array();
		foreach($dataReader as $row)
		{
			$copyfrom_array[$row['id']]['id']=$row['id'];
			$copyfrom_array[$row['id']]['sitename']=$row['sitename'];
			$copyfrom_array[$row['id']]['siteurl']=$row['siteurl'];
			$copyfrom_array[$row['id']]['thumb']=$row['thumb'];
			$copyfrom_array[$row['id']]['is_default']=$row['is_default'];
			$copyfrom_array[$row['id']]['listorder']=$row['listorder'];
		}
		Yii::app()->cache->set($this->cacheName,$copyfrom_array);
	}
	
	//更新敏感词记录缓存
	private function _updateBadwordCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{badword}}')->order('level DESC');
		$dataReader=$command->query();
		$search_array=array();
		$replace_array=array();
		foreach($dataReader as $row)
		{
			$search_array[$row['id']]=$row['badword'];
			$replace_array[$row['id']]=$row['level']==2?'':$row['replaceword'];
		}
		$badword_array=array('search_array'=>$search_array,'replace_array'=>$replace_array);
		Yii::app()->cache->set($this->cacheName,$badword_array);
	}
	
	//更新栏目配置参数记录缓存
	private function _updateColumnParamCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{column_param}}');
		$dataReader=$command->query();
		$column_param_array=array();
		foreach($dataReader as $row)
		{
			$column_param_array[$row['column_id']]=unserialize($row['value']);
		}
		Yii::app()->cache->set($this->cacheName,$column_param_array);
	}
	
	//更新栏目配置参数记录缓存
	private function _updatePositionCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{position}}');
		$dataReader=$command->query();
		$position_array=array();
		foreach($dataReader as $row)
		{
			$position_array[$row['type']][$row['key_name']]=$row['description'];
		}
		Yii::app()->cache->set($this->cacheName,$position_array);
	}
	
    //更新广告数据缓存
	private function _updateAdvertCache(){
		$advert_data=Advert::model()->with('items')->findAll();
		$advert_array=array();
		foreach ($advert_data as $v){
			$advert_array[$v->position_key]=$v->attributes;
			$items_array=array();
			foreach ($v->items as $item){
				$items_array[]=$item->attributes;
			}
			$advert_array[$v->position_key]['items']=$items_array;
		}
		Yii::app()->cache->set($this->cacheName,$advert_array);
	}
	
    //更新内容发布版位数据缓存
	private function _updateReleaseCache(){
		$connection=Yii::app()->db;
		$command=$connection->createCommand()->select('*')->from('{{release_content}}')->order('release_id DESC,listorder ASC');
		$dataReader=$command->query();
		$release_array=array();
		foreach($dataReader as $row)
		{
			$release_info=Release::model()->findByPk($row['release_id']);
			$release_array[$release_info->key_name][$row['id']]=$row;
			$release_array[$release_info->key_name][$row['id']]['release_info']=$release_info;
		}
		Yii::app()->cache->set($this->cacheName,$release_array);
	}
	
}