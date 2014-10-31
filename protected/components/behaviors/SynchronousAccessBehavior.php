<?php

class SynchronousAccessBehavior extends CActiveRecordBehavior{
	
	public function afterSave($event){
		$auth=Yii::app()->authManager;
		Yii::app()->cacheManage->cacheName='MenuCache';
		$menu_cache=Yii::app()->cacheManage->findCache();
		$tree=new Tree();
		$tree->init($menu_cache);
		$menu_level=$tree->get_level($this->owner->id);
		$type=$menu_level==3? 1:0;
		$auth_name=!empty($this->owner->m)?$this->owner->m.'_'.$this->owner->c.'_'.$this->owner->a:$this->owner->c.'_'.$this->owner->a;	
		$auth_name=!empty($this->owner->data)&&is_array(Util::param2array($this->owner->data))&&array_key_exists('form_type',Util::param2array($this->owner->data))?$auth_name.'_'.Util::param2array($this->owner->data)['form_type']:$auth_name;
		if($menu_level==3||$menu_level==4){
		    $row=Yii::app()->db->createCommand()->from('{{authitem}}')->where('menu_id=:menu_id',array(':menu_id'=>$this->owner->id))->queryRow();
		    if($row!==null){
		        $auth->removeAuthItem($row['name']);
		    }
		    $auth_item=$auth->getAuthItem($auth_name);
	        if($auth_item===null){
				Yii::app()->db->createCommand()
					->insert('{{authitem}}', array(
					'name'=>$auth_name,
					'type'=>$type,
					'description'=>$this->owner->name,
					'bizrule'=>null,
					'data'=>serialize(null),
					'menu_id'=>$this->owner->id
				));
				if($menu_level==4){
					$parent_menu=$menu_cache[$menu_cache[$this->owner->id]['parentid']];
					$parent_auth_name=!empty($parent_menu['m'])?$parent_menu['m'].'_'.$parent_menu['c'].'_'.$parent_menu['a']:$parent_menu['c'].'_'.$parent_menu['a'];
					$task=$auth->getAuthItem($parent_auth_name);
					if($task===null){
					    Yii::app()->db->createCommand()
					        ->insert('{{authitem}}', array(
					        'name'=>$parent_auth_name,
					        'type'=>3,
					        'description'=>$parent_menu['name'],
					        'bizrule'=>null,
					        'data'=>serialize(null),
					        'menu_id'=>$parent_menu['id']
					    ));
					    $task=$auth->getAuthItem($parent_auth_name);
					}					
					$task->addChild($auth_name);
				}
			}
		}
		return parent::afterSave($event);
	}
	
	public function afterDelete($event){
		$auth=Yii::app()->authManager;
		$auth_name=!empty($this->m)?$this->owner->m.'_'.$this->owner->c.'_'.$this->owner->a:$this->owner->c.'_'.$this->owner->a;
		$auth->removeAuthItem($auth_name);
		return parent::afterDelete($event);
	}
	
}

?>