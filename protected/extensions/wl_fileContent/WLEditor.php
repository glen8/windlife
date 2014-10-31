<?php

class WLEditor extends CInputWidget{
	
	public $language = 'zh-cn';
	
	public $toolbars = '';
	
	public $htmlOptions = array();
	
	public $editorOptions = array();
	
	public $debug = false;
	
	public $width = '100%';
	
	public $height = '400';
	
	public $theme = 'default';
	
	//是否根据用户ID存储图片
	public $isUser=false;
	
	public function run(){
		list($name, $id) = $this->resolveNameID();
		$cs = Yii::app()->getClientScript();
		
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/ueditor/ueditor.config.js');
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/ueditor/ueditor.all.js');
		
		$this->htmlOptions['id'] = $id;
		
		if (!array_key_exists('style', $this->htmlOptions)) {
			$this->htmlOptions['style'] = "width:{$this->width};";
		}
		
		if($this->toolbars){
			$this->editorOptions['toolbars'][] = $this->toolbars;
		}
		
		$user_path=$this->isUser&&isset(Yii::app()->user->id)&&is_int(Yii::app()->user->id)?Yii::app()->user->id:0;
		
		$options['theme']=$this->theme;
		$options['lang']=$this->language;
		$options['initialFrameWidth']=$this->width;
		$options['initialFrameHeight']=$this->height;
		$options['imageManagerPath'] = '';
		$options['imageManagerUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/imageManager'):Yii::app()->createUrl(Yii::app ()->controller->id.'/imageManager');
		$options['imagePath'] = '';
		$options['imageUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/imageUp'):Yii::app()->createUrl(Yii::app ()->controller->id.'/imageUp');
		$options['catcherPath'] = '';
		$options['catcherUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/remoteImage'):Yii::app()->createUrl(Yii::app ()->controller->id.'/remoteImage');
		$options['fileUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/fileUp'):Yii::app()->createUrl(Yii::app ()->controller->id.'/fileUp');
		$options['filePath'] = '';
		$options['wordImagePath'] = '';
		$options['wordImageUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/imageUp'):Yii::app()->createUrl(Yii::app ()->controller->id.'/imageUp');
		$options['getMovieUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/movie'):Yii::app()->createUrl(Yii::app ()->controller->id.'/movie');
		$options['scrawlPath'] = '';
		$options['scrawlUrl'] = isset(Yii::app ()->controller->module->id)?Yii::app()->createUrl(Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/scrawlUp'):Yii::app()->createUrl(Yii::app ()->controller->id.'/scrawlUp');
		
		
		$options['image_path'] = './uploadfiles/images/'.$user_path;
		$options['file_path'] = './uploadfiles/attachments/'.$user_path;
		if ( !file_exists( $options['image_path'] ) ) {
			mkdir( "{$options['image_path']}" , 0777 );
		}
		if ( !file_exists( $options['file_path'] ) ) {
			mkdir( "{$options['file_path']}" , 0777 );
		}
		$options['YII_CSRF_TOKEN'] = Yii::app()->request->csrfToken;
		
		$options = CJSON::encode(array_merge($options,$this->editorOptions));
		
		$js ="UE.getEditor('{$id}',{$options})";
		// Register js code
		$cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_READY);
		
		// Do we have a model
		if($this->hasModel()) {
			$html = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		} else {
			$html = CHtml::textArea($name, $this->value, $this->htmlOptions);
		}
		
		echo $html;
	}
	
}

?>