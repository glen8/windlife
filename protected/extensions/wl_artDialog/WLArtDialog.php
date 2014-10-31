<?php
class WLArtDialog extends CWidget{
	
	//主题
	public $skin='default';
 
    //宽
    public $width='500';
	
	//高
	public $height='500';
	
	//地址	
	public $url;
	
	//标题
	public $title="设置";
	
	//触发内容
	public $content;
	
	//调试模式
	public $debug=false;
	
	//是否为表单内容
	public $is_form='1';
	
	//表单名称
	public $form_name='form';
	
	//样式
	public $cssClass='';
	
	public function run(){		
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'artDialog');
		$cs = Yii::app()->getClientScript();		
		$jsFile_artDialog = ($this->debug ? 'jquery.artDialog.source.js' : 'jquery.artDialog.js').'?skin='.$this->skin;
		$jsFile_iframe = $this->debug ? 'iframeTools.source.js' : 'iframeTools.js';
		
		
		$cs->registerScriptFile($assets.'/' . $jsFile_artDialog, CClientScript::POS_HEAD);
		$cs->registerScriptFile($assets.'/plugins/' . $jsFile_iframe, CClientScript::POS_HEAD);		
		$cs->registerScriptFile($assets.'/dialog_function.js', CClientScript::POS_HEAD);
		
		$html='<a class="'.$this->cssClass.'" style="cursor:pointer" onclick="dialog_show(\''.$this->title.'\',\''.$this->url.'\',\''.$this->width.'\',\''.$this->height.'\',\''.$this->form_name.'\',\''.$this->is_form.'\');">'.$this->content.'</a>';
		
		echo $html;
	}  
}


?>