<?php
class Banner extends CComponent
{
	
	public $setting;
	
	private $config;

    public $option;
	
	
	public function init(){		
		$this->config=require __DIR__.DIRECTORY_SEPARATOR.'config.php';
	}
	
	public function getCode(){
		$str='';
		if(isset($this->setting['items'][0])){
			foreach ($this->setting['items'] as $v){
				$str.='<div style="width:'.$this->setting['width'].'px;height:'.$this->setting['height'].'px;'.$this->setting['style'].'">';
				$str.='<a url-data="'.$v['link_url'].'" rel="wl_advert_redirect" id-data="'.$v['id'].'" class="cursor" target="'.$v['target'].'">';
				$str.='<img src="'.Yii::app()->baseUrl.$v['file_url'].'" width="'.$this->setting['width'].'" height="'.$this->setting['height'].'" alt="'.$v['title'].'" />';
				$str.='</a></div>';
			}				
		}
		return $str;
	}
}