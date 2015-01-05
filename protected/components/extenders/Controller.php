<?php
class Controller extends CController {
	
	public $menu = array ();
	public $breadcrumbs = array ();
	public $column;
	public $category=array();
	public $metaKeywork;
	public $metaDescription;
	
	public function beforeAction($action) {
		Yii::app ()->cacheManage->cacheName = 'ContentCache';
		$this->menu = Yii::app ()->cacheManage->findCache ();
		Yii::app ()->cacheManage->cacheName = 'ClassifyCache';
		$this->category = Yii::app ()->cacheManage->findCache ();
		Yii::app ()->clientScript->registerCoreScript ( 'jquery' )
        //->registerScriptFile ( Yii::app ()->baseUrl . '/scripts/ jquery.mobile.min.js' )
        ->registerScriptFile ( Yii::app ()->baseUrl . '/scripts/function.js' )
		->registerCssFile ( Yii::app ()->baseUrl . '/css/style.css' );
		
		if(isset($_GET['keyparam'])){
			foreach ($this->menu as $v){
				if($v['keyparam']==$_GET['keyparam']){
					$this->column=$v;
					break;
				}
			}
		}
		
		return parent::beforeAction ( $action );
	}
	
	public function beforeRender($view){
		if(isset($_GET['id'])){
			Yii::app()->cacheManage->cacheName='ModelCache';
			$model_cache=Yii::app()->cacheManage->findCache();
			$model_now=$model_cache[$this->column['modelid']];
			$info=BaseModel::model($model_now['object'])->findByPk((int)$_GET['id']);
			$this->pageTitle=$info->title.' - '.$this->column['colname'].' - '.SettingGet::get('base', 'title');
			$cs=Yii::app()->clientScript;
			$cs->registerMetaTag($info->keywords.','.SettingGet::get('base', 'title'),'keywords');
			$cs->registerMetaTag($info->description.' '.SettingGet::get('base', 'title'),'description');
		}
		elseif(isset($_GET['keyparam'])){
			$this->pageTitle=$this->column['colname'].' - '.SettingGet::get('base', 'title');
			$seo_info=unserialize($this->column['setting']);
			$cs=Yii::app()->clientScript;
			$cs->registerMetaTag($seo_info['metaKeyword'].','.SettingGet::get('base', 'title'),'keywords');
			$cs->registerMetaTag($seo_info['metaDescription'].' '.SettingGet::get('base', 'title'),'description');
		}
		else{
			$this->pageTitle=SettingGet::get('base', 'title').(SettingGet::get('base', 'subTitle')!=''?' - '.SettingGet::get('base', 'subTitle'):'');
			$cs=Yii::app()->clientScript;
			$cs->registerMetaTag(SettingGet::get('base', 'metaKeyword'),'keywords');
			$cs->registerMetaTag(SettingGet::get('base', 'metaDescription'),'description');
		}		
		return parent::beforeRender($view);
	}
}