<?php
class Stripfocus extends CComponent
{
	
	public $setting;
	
	private $config;

    public $option;
	
	public function init(){		
		$this->config=require __DIR__.DIRECTORY_SEPARATOR.'config.php';
	}
	
	public function getCode(){		
		$baseDir = dirname ( __FILE__ );
		$assets = Yii::app ()->getAssetManager ()->publish ( $baseDir . DIRECTORY_SEPARATOR . 'assets' );
		$cs = Yii::app ()->getClientScript ();
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile ( $assets . '/jquery.stripfocus.js' );
		$cs->registerCssFile ( $assets . '/jquery.stripfocus.css' );
		$str='<div id="focus'.$this->setting['id'].'" class="wl_advert_stripfocus" style="width:'.$this->setting['width'].'px;height:'.$this->setting['height'].'px;'.$this->setting['style'].'"><ul style="width:'.$this->setting['width'].'px;height:'.$this->setting['height'].'px;'.$this->setting['style'].'">';
		if(isset($this->setting['items'][0])){
			foreach ($this->setting['items'] as $v){
				$str.='<li style="width:'.$this->setting['width'].'px;height:'.$this->setting['height'].'px;'.$this->setting['style'].'">';
				$str.='<a url-data="'.$v['link_url'].'" rel="wl_advert_redirect" id-data="'.$v['id'].'" class="cursor" target="'.$v['target'].'">';
				$str.='<img src="'.Yii::app()->baseUrl.$v['file_url'].'" width="'.$this->setting['width'].'" height="'.$this->setting['height'].'" alt="'.$v['title'].'" />';
				$str.='</a></li>';
			}				
		}
		$str.='</ul></div>';
		$str.="<script>$('#focus{$this->setting['id']}').stripfocus();</script>";
		return $str;
	}
}