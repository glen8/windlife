<?php
class WLFileUpload extends CInputWidget {
	
	// html 选项
	public $htmlOptions = array ();
	
	// 外框样式
	public $borderCss = "wl_fileupload_border_css";
	
	// 按钮样式
	public $buttonCss = "wl_fileupload_button_css";
	
	//是否根据用户ID存储图片
	public $isUser=false;
	
	//编辑器选项
	public $editorOptions=array();
	
	public function run() {
		list ( $name, $id ) = $this->resolveNameID ();
		$this->htmlOptions ['id'] = $id;
		$baseDir = dirname ( __FILE__ );
		$assets = Yii::app ()->getAssetManager ()->publish ( $baseDir . DIRECTORY_SEPARATOR . 'assets' );
		$cs = Yii::app ()->getClientScript ();
		$cs->registerScriptFile ( Yii::app ()->request->baseUrl . '/ueditor/ueditor.config.js' );
		$cs->registerScriptFile ( Yii::app ()->request->baseUrl . '/ueditor/ueditor.all.js' );
		$cs->registerCssFile ( $assets . '/filecontent.css' );
		
		$user_path=$this->isUser&&isset(Yii::app()->user->id)&&is_int(Yii::app()->user->id)?Yii::app()->user->id:0;
		$options['fileUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/fileUp'):Yii::app()->createUrl(Yii::app ()->controller->id.'/fileUp');
		$options['filePath'] = '';
	    $options['file_path'] = './uploadfiles/attachments/'.$user_path;
	
	    if ( !file_exists( $options['file_path'] ) ) {
	    	mkdir( "{$options['file_path']}" , 0777 );
	    }
	    
	    $options['YII_CSRF_TOKEN'] = Yii::app()->request->csrfToken;
		$options = CJSON::encode(array_merge($options,$this->editorOptions));
		
		$js = "var wl_fileupload_{$id}_editor = UE.getEditor('{$id}_upload_button:files',{$options});\n";
		$js .= "var show_{$id};\n";
		$js .= "function wl_fileupload_{$id}(address){\n";
		$js .= "show_{$id} = wl_fileupload_{$id}_editor.getDialog('attachment');\n";
		$js .= "show_{$id}.open();\n";
		$js .= "wl_fileupload_{$id}_editor.addListener('beforeInsertFile',function(t, arg){\n";
		$js .= "for(var ele in arg){\n";
		$js .= "document.getElementById(address).value = arg[ele].newUrl;\n";
		$js .= "}});}";
		$cs->registerScript ( 'Yii.' . get_class ( $this ) . '#' . $id, $js, CClientScript::POS_END );
		$html = "<div class=\"{$this->borderCss}\">";
		if ($this->hasModel ()) {
			$html .= CHtml::activeTextField ( $this->model, $this->attribute, $this->htmlOptions );
		} else {
			$html .= CHtml::textField ( $name, $this->value, $this->htmlOptions );
		}
		$html .= "<input type=\"button\" class=\"{$this->buttonCss}\" id=\"{$id}_upload_button:files\" value=\"上传文件\" onclick=\"wl_fileupload_{$id}('{$id}')\" />";
		$html .= "</div>";
		echo $html;
	}
}

?>