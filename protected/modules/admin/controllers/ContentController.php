<?php
class ContentController extends AdminController {	
	
    public function actionInit() {		
		Yii::app()->cacheManage->cacheName='ContentCache';
		$content_cache=Yii::app()->cacheManage->findCache();
		Yii::app()->cacheManage->cacheName='ModelCache';
		$model_cache=Yii::app()->cacheManage->findCache();
		$column_data=$this->_getChildColumn($content_cache, $model_cache, 0);
		$this->render ( "init", array('column_data'=>$column_data) );
	}
	
	public function actionFindColumn() {
		$this->layout = false;
		$column_tmp_array=Column::model()->findAll("module='content' and type='1' and dataway='2'");
		$column_data=array();
		Yii::app()->cacheManage->cacheName='ModelCache';
		$model_cache=Yii::app()->cacheManage->findCache();
		foreach ($column_tmp_array as $v){
			$column_model=$model_cache[$v['modelid']];
			$tmp_array=array();
			$tmp_array['label']=$v->colname;
			$tmp_array['url']=!empty($column_model['m_module'])?Yii::app()->createUrl($column_model['m_module'].'/'.$column_model['m_controller'].'/'.$column_model['m_action'],array('column_id'=>$v['id'])):Yii::app()->createUrl($column_model['m_controller'].'/'.$column_model['m_action'],array('column_id'=>$v['id']));
			$column_data[]=$tmp_array;
			$tmp_array['label']=$v->letter;
			$column_data[]=$tmp_array;
		}
		$this->render ( 'findColumn' ,array('column_data'=>$column_data));
	}
	
	
	private function _getChildColumn($content_cache,$model_cache,$parentid){
		$column_data=array();
		$column_array=array();
		$listorder=array();
		$id=array();
		foreach ($content_cache as $k=>$v){
			if($v['parentid']==$parentid&&($v['type']==1||$v['child']==1)){
				$column_array[]=$v;
				$listorder[$k]=$v['listorder'];
				$id[$k]=$v['id'];
			}
		}
		array_multisort($listorder,SORT_ASC,$id,SORT_ASC,$column_array);
		foreach ($column_array as $k=>$v){
			$tmp_array=array();
			$tmp_array['id']=$v['id'];
			if(isset($model_cache[$v['modelid']]))$column_model=$model_cache[$v['modelid']];
			if($v['type']==1){
				switch ($v['dataway']){
					case 1:
						if($v['child']==1){
						    $tmp_array['text']="<span class=\"folder\">{$v['colname']}</span>";
						}
						break;
					case 2:
						$icon=$column_model['data_num']==1?'list':'file';
						$manager_url=!empty($column_model['m_module'])?Yii::app()->createUrl($column_model['m_module'].'/'.$column_model['m_controller'].'/'.$column_model['m_action'],array('column_id'=>$v['id'])):Yii::app()->createUrl($column_model['m_controller'].'/'.$column_model['m_action'],array('column_id'=>$v['id']));
						$tmp_array['text']="<span class=\"{$icon}\"><a href=\"{$manager_url}\" target=\"main\">{$v['colname']}</a></span>";
						break;
					case 3:
						if($v['datachild']>0){
							$tmp_array['text']="<span class=\"parent\">{$v['colname']}</span>";
						}
						break;
					default:
						$tmp_array['text']="<span class=\"folder\">{$v['colname']}</span>";
						break;
				}
				if($v['child']==1){
					$tmp_array['hasChildren']=true;
					$tmp_array['children']=$this->_getChildColumn($content_cache,$model_cache,$v['id']);
				}
				else{
					$tmp_array['hasChildren']=false;
				}
			}
			else{
				$tmp_array['text']="<span class=\"folder\">{$v['colname']}</span>";
				$tmp_array['hasChildren']=true;
				$tmp_array['children']=$this->_getChildColumn($content_cache,$model_cache,$v['id']);
			}
			$column_data[]=$tmp_array;
		}
		return $column_data;
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	
}