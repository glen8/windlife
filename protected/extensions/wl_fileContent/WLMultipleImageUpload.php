<?php

class WLMultipleImageUpload extends CInputWidget{
		
	//最外框样式
	public $borderCss="wl_multiple_image_upload_border_css";
	
	//fieldest框样式
	public $fieldestCss="wl_multiple_image_upload_fieldest_css";
	
	//最大上传图片数量
	public $img_num=32;
	
	//上传按钮图片背景
	public $bgImage="picBnt.png";
	
	//文件路径文本框宽度
	public $pathInputWidth="310";
	
	//文件描述文本框宽度
	public $desnInputWidth="160";
	
	//文本框样式
	public $inputCss="";
	
	//是否根据用户ID存储图片
	public $isUser=false;
	
	//图片alt列表字段
	public $attribute_alt;
	
	//编辑器选项
	public $editorOptions=array();
	
	public function run(){
		list($name, $id) = $this->resolveNameID();
		$this->htmlOptions['id'] = $id;
		$baseDir = dirname(__FILE__);
		$assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');
		$cs = Yii::app()->getClientScript();
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
		
		$options['maxNum'] = $this->img_num;
		
		if ( !file_exists( $options['image_path'] ) ) {
			mkdir( "{$options['image_path']}" , 0777 );
		}
		
		$options['YII_CSRF_TOKEN'] = Yii::app()->request->csrfToken;
		$options = CJSON::encode(array_merge($options,$this->editorOptions));
		
		$js="var wl_multiple_imageupload_{$id}_editor = UE.getEditor('{$id}_multiple_upload_button:imgs',{$options});\n";
		$js.="var show_{$id};\n";
		$js.="function wl_multiple_imageupload_{$id}(address){\n";
		$js.="show_{$id} = wl_multiple_imageupload_{$id}_editor.getDialog('insertimage');\n";
		$js.="show_{$id}.open();\n";
		$js.="wl_multiple_imageupload_{$id}_editor.addListener('beforeInsertImage',function(t, arg){\n";
		$js.="var str='';\n";
		$js.="var file_url;\n";
		$js.="for(var ele in arg){;\n";
		$js.="var alt=arg[ele].title!=undefined?arg[ele].title:arg[ele].alt;\n";
		$js.="file_url=arg[ele].src;\n";
		$js.="str+='<p><input class=\"{$this->inputCss} filepath\" name=\"{$id}_urls[]\" value=\"'+arg[ele].src+'\" style=\"width:{$this->pathInputWidth}px;\" type=\"text\" />';\n";
		$js.="str+='<input class=\"{$this->inputCss} img_alt\" name=\"{$id}_alts[]\" value=\"'+alt+'\" style=\"width:{$this->desnInputWidth}px;\"  type=\"text\" />';\n";
		$js.="str+='<a style=\"cursor: pointer;\" rel=\"remove-img\">移除</a></p>';\n";
		$js.="}\n";	
		$js.="var content_obj=document.getElementById(address+'_pictureurls');\n";	
		$js.="var content=content_obj.innerHTML;\n";
		$js.="if(content.indexOf(file_url)==-1){\n";
		$js.="content_obj.innerHTML=content_obj.innerHTML+str;\n";
		$js.="var img_array=$('#{$id}_pictureurls input.filepath');\n";
		$js.="var alt_array=$('#{$id}_pictureurls input.img_alt');\n";
		$js.="var str_img_list=str_alt_list='';\n";
		$js.="for(var i=0;i<img_array.length;i++){\n";
		$js.="str_img_list+=(i==0)?img_array[i].value:'#|#'+img_array[i].value;\n";
		$js.="str_alt_list+=(i==0)?alt_array[i].value:'#|#'+alt_array[i].value;\n";
		$js.="}\n";
	    $alt_id=CHtml::getIdByName(CHtml::resolveName($this->model, $this->attribute_alt));
		$js.="$('#{$id}').val(str_img_list);\n";
		$js.="$('#{$alt_id}').val(str_alt_list);\n";
		$js.="}});}\n";
		$js.="$(document).ready(function(){\n";
		$js.="$(document).on('dblclick',\".wl_picList input.filepath\",function(){\n";
		$js.="var view_img_url=$(this).val();\n";
		$js.="if(view_img_url!=null&&view_img_url!=''){\n";
		$js.="$( '#view_dialog' ).remove();\n";
		$js.="$('body').append('<div id=\"view_dialog\" style=\"display:none;text-align: center;\"><img src=\"'+view_img_url+'\" style=\"max-width: 400px;max-height: 400px;\" /> </div>');\n";
		$js.="$( '#view_dialog' ).dialog();\n";
		$js.="}});\n";
		$js.="$(document).on('click',\"#{$id}_pictureurls a[rel=remove-img]\",function(){\n";
		$js.="$(this).parent().remove();\n";
		$js.="var img_array=$('#{$id}_pictureurls input.filepath');\n";
		$js.="var alt_array=$('#{$id}_pictureurls input.img_alt');\n";
		$js.="var str_img_list=str_alt_list='';\n";
		$js.="for(var i=0;i<img_array.length;i++){\n";
		$js.="str_img_list+=(i==0)?img_array[i].value:'#|#'+img_array[i].value;\n";
		$js.="str_alt_list+=(i==0)?alt_array[i].value:'#|#'+alt_array[i].value;\n";
		$js.="}\n";
		$js.="$('#{$id}').val(str_img_list);\n";
		$js.="$('#{$alt_id}').val(str_alt_list);\n";
		$js.="});\n";
		$js.="});\n";
		$cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_END);
		$html="<div class=\"{$this->borderCss}\">";
		$html.="<fieldset class=\"{$this->fieldestCss}\">";
		$html.="<legend>图片列表</legend>\n";
		$html.="<div id=\"nameTip\" class=\"onShow\" style=\"background: url({$assets}/msg_bg.png) no-repeat 3px -148px;\">您最多可以同时上传<span style=\"color:red;\">{$this->img_num}</span>张</div>\n";
		$html.="<div class=\"wl_picList\" id=\"{$id}_pictureurls\">";
		$model_img_valus=explode('#|#',CHtml::resolveValue($this->model, $this->attribute));
		$model_alt_valus=explode('#|#',CHtml::resolveValue($this->model, $this->attribute_alt));
		if(CHtml::resolveValue($this->model, $this->attribute)!=''){
		    for($i=0;$i<count($model_img_valus);$i++){
			    $html.="<p><input class=\"{$this->inputCss} filepath\" name=\"{$id}_urls[]\" value=\"{$model_img_valus[$i]}\" style=\"width:{$this->pathInputWidth}px;\" type=\"text\" />";
			    $html.="<input class=\"{$this->inputCss} img_alt\" name=\"{$id}_alts[]\" value=\"{$model_alt_valus[$i]}\" style=\"width:{$this->desnInputWidth}px;\"  type=\"text\" />";
			    $html.="<a style=\"cursor: pointer;\" rel=\"remove-img\">移除</a></p>";
		    }
		}
		$html.="</div></fieldset>";
		$img_url= $this->bgImage=='picBnt.png'?$assets.'/'.$this->bgImage:$this->bgImage;
		$html.="<input type=\"image\" src=\"{$img_url}\" style=\"margin:10px 0;\" id=\"{$id}_multiple_upload_button:imgs\" onclick=\"wl_multiple_imageupload_{$id}('{$id}')\" />";
		if($this->hasModel()) {
			$html .= CHtml::activeHiddenField($this->model, $this->attribute);
		} 
		if($this->hasModel()) {
			$html .= CHtml::activeHiddenField($this->model, $this->attribute_alt);
		} 
		$html .="</div>";
		echo $html;
		
	}
	
}

?>