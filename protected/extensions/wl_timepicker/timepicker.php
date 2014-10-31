<?php
class timepicker extends CInputWidget {

	public $assets = '';
	public $options = array();
	public $htmlOptions = array();
	public $skin = 'default';
	
	public $model;
	public $name;
	public $language;
	public $select = 'datetime'; # also avail 'time' and 'date'

	public function init() {
		
		list($name, $id) = $this->resolveNameID();
		
		$this->assets = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
		
	
		Yii::app()->clientScript
		->registerCoreScript( 'jquery' )
		->registerCoreScript( 'jquery.ui' )
        
		->registerScriptFile( $this->assets.'/js/jquery.ui.timepicker.js' )
		->registerCssFile( $this->assets.'/css/timepicker.css' );
		
		//language support
		if (empty($this->language))
			$this->language = Yii::app()->language;
 
		if(!empty($this->language)){
			$path = dirname(__FILE__).DIRECTORY_SEPARATOR.'assets';
			$langFile = '/js/jquery.ui.timepicker.'.$this->language.'.js';

			if (is_file($path.DIRECTORY_SEPARATOR.$langFile))
				Yii::app()->clientScript->registerScriptFile($this->assets.$langFile);
		}
		
		$this->htmlOptions['id'] = $id;
        
		$default = array(
			'dateFormat'=>'yy-mm-dd',
			'timeFormat'=>'hh:mm:ss',
			//'showOn'=>'button',
			'showSecond'=>false,
			'changeMonth'=>false,
			'changeYear'=>false,
			'value'=>'',
			'tabularLevel'=>null,
		    
		);

		$this->options = array_merge($default, $this->options);
        
		$options=empty($this->options) ? '' : CJavaScript::encode($this->options);

		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id,"
			jQuery('#{$id}').".$this->select."picker($options);
		");
		
		if($this->hasModel()) {
			$html = CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
		} else {
			$html = CHtml::textField($name, $this->value, $this->htmlOptions);
		}
		
		echo $html;
	}
}
?>