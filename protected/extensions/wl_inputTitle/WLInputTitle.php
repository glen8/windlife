<?php
class WLInputTitle extends CInputWidget {
	
	//样式隐藏域名称
	public $styleName;
	
	//样式隐藏域属性
	public $styleAttribute;
	
	//样式隐藏域值
	public $styleValue;
	
	//字符最大长度
	public $maxLength;
	
	//颜色选择钮样式
	public $imgCss;
	
	// html 选项
	public $htmlOptions = array ();
	
	
	public function run() {
		list ( $name, $id ) = $this->resolveNameID ();
		$this->htmlOptions ['id'] = $id;
		$baseDir = dirname ( __FILE__ );
		$assets = Yii::app ()->getAssetManager ()->publish ( $baseDir . DIRECTORY_SEPARATOR . 'assets' );
		$cs = Yii::app ()->getClientScript ();
		$cs->registerCoreScript( 'jquery' );
		$cs->registerScriptFile( $assets.'/js/jquery.bigcolorpicker.js' );
		$cs->registerCssFile( $assets.'/css/jquery.bigcolorpicker.css' );
		
		if(!empty($this->maxLength))$this->htmlOptions ['maxLength'] = $this->maxLength;
		
		$title_input_id=$this->hasModel ()?CHtml::activeId($this->model, $this->attribute):$this->name.'_id';
		$style_input_id=$this->hasModel ()?CHtml::activeId($this->model, $this->styleAttribute):$this->styleName.'_id';
		
		$js = "$(document).ready(function(){\n";
		$js .= "$(\"#input_title_select\").bigColorpicker(function(el,value,style){\n";
		$js .= "$(\"#\" + $(el).attr(\"data-target\")).css(style,value);\n";
		$js .= "$(\"#\" + $(el).attr(\"style-target\")).val(style_group($(\"#\" + $(el).attr(\"style-target\")).val(),style,value));\n";
		$js .= "});\n";
		$js .= "$(document).on('click','a[rel=bigpicker_clear]',function(){\n";
		$js .= "$('#{$title_input_id}').css('color','');\n";
		$js .= "$('#{$title_input_id}').css('font-weight','normal');\n";
		$js .= "$('#{$title_input_id}').css('font-style','normal');\n";
		$js .= "$('#{$style_input_id}').val('');\n";
		$js .= "});\n";
		$js .= "});\n";
		$cs->registerScript ( 'Yii.' . get_class ( $this ) . '#' . $id, $js, CClientScript::POS_END );
		
		if(isset($this->model->style)&&!empty($this->model->style)){
			$style_array=$this->htmlOptions;
			$style_array['style']=$style_array['style'].';'.$this->model->style;
			$this->htmlOptions=$style_array;
		}
		
		if(!empty($this->styleValue)){
			$style_array=$this->htmlOptions;
			$style_array['style']=$style_array['style'].';'.$this->styleValue;
			$this->htmlOptions=$style_array;
		}
		
		$html='';
		if ($this->hasModel ()) {
			$html .= CHtml::activeTextField ( $this->model, $this->attribute, $this->htmlOptions );
			$html .= '<img src="'.$assets.'/img/colour.png'.'" style="'.$this->imgCss.'" data-target="'.$title_input_id.'" style-target="'.$style_input_id.'" id="input_title_select" />';
			$html .= CHtml::activeHiddenField($this->model, $this->styleAttribute );
		} else {
			$html .= CHtml::textField ( $name, $this->value, $this->htmlOptions );
			$html .= '<img src="'.$assets.'/img/colour.png'.'" style="'.$this->imgCss.'" data-target="'.$title_input_id.'" style-target="'.$style_input_id.'" id="input_title_select" />';
			$html .= CHtml::hiddenField( $this->styleName, $this->styleValue );
		}
			
		echo $html;
	}
}

?>