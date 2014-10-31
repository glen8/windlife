<?php

class ParamGet extends CComponent
{
	
	private static $value;
	public function init(){self::$value=null;}
	
	public static function get($column_id,$position,$key){
		self::getValue($column_id, $position, $key);
		if(self::$value){
			return self::$value;
		}
		throw new CHttpException(404,'参数不存在，请到后台设置栏目参数');
	}
	
	private static function getValue($column_id,$position,$key){
		Yii::app()->cacheManage->cacheName='ColumnParamCache';
		$column_param_cache=Yii::app()->cacheManage->findCache();		
		if(isset($column_param_cache[$column_id][$position][$key])){
			self::$value=$column_param_cache[$column_id][$position][$key];
		}
		else{
			self::setDefaultValue($column_id);			
			Yii::app()->cacheManage->cacheName='ColumnParamCache';
			$column_param_cache=Yii::app()->cacheManage->findCache();
			if(isset($column_param_cache[$column_id][$position][$key])){
				self::$value=$column_param_cache[$column_id][$position][$key];
			}
		}
	}
	
	private static function setDefaultValue($column_id){
		$column_param=ColumnParam::model()->find('column_id=:column_id',array('column_id'=>$column_id));
		$model_id=0;
		$model_param_value=array();
		if($column_param!==null){
			$model_id=$column_param->model_id;
			$model_param_value=unserialize($column_param->value);
		}
		else{
			Yii::app()->cacheManage->cacheName='ContentCache';
			$content_cache=Yii::app()->cacheManage->findCache();
			$model_id=$content_cache[$column_id]['modelid'];
		}
		if($model_id>0){
			$connection=Yii::app()->db;
			$command=$connection->createCommand()->select('*')->from('{{model_param}}')->where('model_id=:model_id',array('model_id'=>$model_id));
			$dataReader=$command->query();
			$model_param_array=array();
			foreach($dataReader as $row){
				$model_param_array[$row['position']][$row['key']]=isset($model_param_value[$row['position']][$row['key']])?$model_param_value[$row['position']][$row['key']]:$row['default_value'];
			}
			$column_param=$column_param!==null?$column_param:new ColumnParam();
			$column_param->column_id=$column_id;
			$column_param->model_id=$model_id;
			$column_param->value=serialize($model_param_array);
			$column_param->save(false);
		}
	}
}