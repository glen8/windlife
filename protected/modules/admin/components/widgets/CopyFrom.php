<?php
class CopyFrom extends CInputWidget{
	
	// html 选项
	public $htmlOptions = array ();
	
	//下拉菜单样式
	public $selectCss;
	
	//下拉菜单数据
	public $selectData;
	
	public function run(){		
		list ( $name, $id ) = $this->resolveNameID ();
		$this->htmlOptions ['id'] = $id;
		$cs = Yii::app ()->getClientScript ();
		$cs->registerCoreScript( 'jquery' );
		
		$first=current($this->selectData);
		$selected=$first['is_default']==1?$first['sitename']:'';
		
		$js = "$(document).ready(function(){\n";
		$js .= "$('#copyFromSelect').change(function(){\n";
		$js .= "$('#{$id}').val($(this).val())\n";
		$js .= "});\n";
		$js .= "});\n";
		$cs->registerScript ( 'Yii.' . get_class ( $this ) . '#' . $id, $js, CClientScript::POS_END );
		
		$html='';
		if ($this->hasModel ()) {
			$field=$this->attribute;
			$this->model->$field=!empty($this->model->$field)?$this->model->$field:$selected;
			$html .= CHtml::activeTextField ( $this->model, $this->attribute, $this->htmlOptions );
			$html .= CHtml::dropDownList('copyFromSelect', $selected, CHtml::listData($this->selectData, 'sitename', 'sitename'),array('class'=>$this->selectCss));
		} else {
			$this->value=!empty($this->value)?$this->value:$selected;
			$html .= CHtml::textField ( $name, $this->value, $this->htmlOptions );
			$html .= CHtml::dropDownList('copyFromSelect', $selected, CHtml::listData($this->selectData, 'sitename', 'sitename'),array('class'=>$this->selectCss));
		}
			
		echo $html;
		
	}
}
?>