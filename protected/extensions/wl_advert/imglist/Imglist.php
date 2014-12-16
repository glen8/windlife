<?php
class Imglist extends CComponent
{
	
	public $setting;
	
	private $config;

    public $option;
	
	
	public function init(){		
		$this->config=require __DIR__.DIRECTORY_SEPARATOR.'config.php';
	}
	
	public function getCode(){
		$str=isset($this->option['ulClass'])?"<ul class=\"{$this->option['ulClass']}\">":'<ul>';
		if(isset($this->setting['items'][0])){
			foreach ($this->setting['items'] as $v){
				$str.=isset($this->option['liClass'])?"<li class=\"{$this->option['liClass']}\">":'<li>';
				$str.='<a url-data="'.$v['link_url'].'" rel="wl_advert_redirect" id-data="'.$v['id'].'" class="cursor" target="'.$v['target'].'">';
				$str.='<img src="'.Yii::app()->baseUrl.$v['file_url'].'" width="'.$this->setting['width'].'" height="'.$this->setting['height'].'" alt="'.$v['title'].'" />';
				$str.='</a></li>';
			}				
		}
        $str.="</ul>";
		return $str;
	}
}