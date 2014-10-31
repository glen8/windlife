<?php
class Jslides extends CComponent{
	
	public $setting;
	
	private $config;
	
	public function init(){
		$this->config=require dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
	}
	
	public function getCode(){
		$baseDir = dirname ( __FILE__ );
		$assets = Yii::app ()->getAssetManager ()->publish ( $baseDir . DIRECTORY_SEPARATOR . 'assets' );
		$cs = Yii::app ()->getClientScript ();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile ( $assets . '/jquery.jslides.js' );
		$cs->registerCssFile ( $assets . '/jquery.jslides.css' );
		$str='<div id="full-screen-slider" style="height:'.$this->setting['height'].'px;">';
		$str.='<ul id="slides" style="height:'.$this->setting['height'].'px;'.$this->setting['style'].'">';
		if(isset($this->setting['items'][0])){
			foreach ($this->setting['items'] as $v){
				$str.='<li style="background: url('.Yii::app()->baseUrl.$v['file_url'].') no-repeat center center;">';
				$str.='<a url-data="'.$v['link_url'].'" rel="wl_advert_redirect" id-data="'.$v['id'].'" class="cursor" target="'.$v['target'].'">'.$v['title'].'</a></li>';
			}
		}
		$str.='</ul></div>';
		return $str;
	}
}

?>