<?php

class WLImageUpload extends CInputWidget{
	
	//显示类型
	public $type='input';
	
	//html 选项
	public $htmlOptions = array();
	
	//外框样式
	public $borderCss="wl_imageuplad_border_css";
	
	//图片类型外框样式
	public $imgBorderCss="wl_imageuplad_img_border_css";
	
	//按钮样式 
	public $buttonCss="wl_imageupload_button_css";
	
	//图片按钮地址
	public $imgButtonUrl='upload_pic.png';
	
	
    //是否根据用户ID存储图片
    public $isUser=false;
    
    //编辑器选项
    public $editorOptions=array();
	
	public function run(){
		list($name, $id) = $this->resolveNameID();
		$this->htmlOptions['id'] = $id;
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');
		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($cs->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
		$cs->registerCoreScript('jquery.ui');
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/ueditor/ueditor.config.js');
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/ueditor/ueditor.all.js');
		$cs->registerCssFile($assets.'/filecontent.css');
		$user_path=$this->isUser&&isset(Yii::app()->user->id)&&is_int(Yii::app()->user->id)?Yii::app()->user->id:0;
		$options['imageManagerPath'] = '';
		$options['imageManagerUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/imageManager'):Yii::app()->createUrl(Yii::app ()->controller->id.'/imageManager');
		$options['imagePath'] = '';
		$options['imageUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/imageUp'):Yii::app()->createUrl(Yii::app ()->controller->id.'/imageUp');
		$options['catcherPath'] = '';
		$options['catcherUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/remoteImage'):Yii::app()->createUrl(Yii::app ()->controller->id.'/remoteImage');
		$options['image_path'] = './uploadfiles/images/'.$user_path;
		
		$options['maxNum'] = 1;		
		
		if ( !file_exists( $options['image_path'] ) ) {
			mkdir( "{$options['image_path']}" , 0777 );
		}
		
		$options['YII_CSRF_TOKEN'] = Yii::app()->request->csrfToken;
		$options = CJSON::encode(array_merge($options,$this->editorOptions));
		switch ($this->type){
			case 'input':
				$js="var wl_imageupload_{$id}_editor = UE.getEditor(\"{$id}_upload_button:imgs\",{$options});\n";
				$js.="var show_{$id};\n";
				$js.="function wl_imageupload_{$id}(address){\n";
				$js.="show_{$id} = wl_imageupload_{$id}_editor.getDialog('insertimage');\n";
				$js.="show_{$id}.open();\n";
				$js.="wl_imageupload_{$id}_editor.addListener('beforeInsertImage',function(t, arg){\n";
				$js.="if(arg.src!=undefined){\n";
				$js.="document.getElementById(address).value = arg.src;\n";
				$js.="}else{\n";
				$js.="for(var ele in arg){\n";
				$js.="document.getElementById(address).value = arg[ele].src;\n";
				$js.="}}});}\n";
				$js.="$(document).ready(function(){\n";
				$js.="$(\".{$this->borderCss} input[type='text']\").dblclick(function(){\n";
				$js.="var view_img_url=$(this).val();\n";
				$js.="if(view_img_url!=null&&view_img_url!=''){\n";
				$js.="$( '#view_dialog' ).remove();\n";
				$js.="$('body').append('<div id=\"view_dialog\" style=\"display:none;text-align: center;\"><img src=\"'+view_img_url+'\" style=\"max-width: 400px;max-height: 400px;\" /> </div>');\n";
				$js.="$( '#view_dialog' ).dialog();";
				$js.="}});";
				$js.="});\n";
				$cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_END);
				$html="<div class=\"{$this->borderCss}\">";
				if($this->hasModel()) {
					$html .= CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
				} else {
					$html .= CHtml::textField($name, $this->value, $this->htmlOptions);
				}
				$html .= "<input type=\"button\" class=\"{$this->buttonCss}\" id=\"{$id}_upload_button:imgs\" value=\"上传图片\" onclick=\"wl_imageupload_{$id}('{$id}')\" />";
				$html .="</div>";
				echo $html;
				break;
			case 'image':
				$js="var wl_imageupload_{$id}_editor = UE.getEditor('{$id}_upload_button:imgs',{$options});\n";
				$js.="var show_{$id};\n";
				$js.="function wl_imageupload_{$id}(address){\n";
				$js.="show_{$id} = wl_imageupload_{$id}_editor.getDialog('insertimage');\n";
				$js.="show_{$id}.open();\n";
				$js.="wl_imageupload_{$id}_editor.addListener('beforeInsertImage',function(t, arg){\n";
				$js.="for(var ele in arg){\n";
				$js.="document.getElementById(address).value = arg[ele].src;\n";
				$js.="var img=new Image();\n";
				$js.="img.src=arg[ele].src;\n";
				$js.="if(img.width/img.height>135/113)\n";
				$js.="{document.getElementById('{$id}_upload_button:imgs').style.width='135px';}\n";
				$js.="else{document.getElementById('{$id}_upload_button:imgs').style.height='113px';}\n";
				$js.="document.getElementById('{$id}_upload_button:imgs').src = arg[ele].src;\n";
				$js.="}});}\n";
				$cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_END);
				$html="<div class=\"{$this->imgBorderCss}\">";
				if($this->hasModel()) {
					$html .= CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
				} else {
					$html .= CHtml::hiddenField($name, $this->value, $this->htmlOptions);
				}
				$img_url= $this->imgButtonUrl=='upload_pic.png'?$assets.'/'.$this->imgButtonUrl:$this->imgButtonUrl;
				$img_value=CHtml::resolveValue($this->model, $this->attribute);
				$img_url= !empty($img_value)?$img_value:$img_url;
				$html .= "<img id=\"{$id}_upload_button:imgs\" src=\"{$img_url}\" style=\"cursor: pointer;width:135px;height:113px\" alt=\"上传图片\" onclick=\"wl_imageupload_{$id}('{$id}')\" />";
				$html .="</div>";
				echo $html;
				break;
		}
	}
	
}

?>