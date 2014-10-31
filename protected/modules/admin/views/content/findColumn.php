<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>快速进入 - <?php echo Yii::app()->name?>网站管理系统</title>
</head>

<body>
<div id="message">
  <h5>快速进入</h5>
  <div class="content" id="find_column" style="background: none">
  <?php 
  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
  		'name'=>'column_name',
  		'source'=>$column_data,
		'value'=>'输入“拼音”或者“栏目名称”可快速搜索',
  		'options'=>array(
            'minLength'=>'1',//设置文本框中有最少有几个字符的时候开始提示
            'select'=>'js:function( event, ui ){location.href=ui.item.url;}',
        ),
        'htmlOptions'=>array(
            'encode'=>false,
            'style'=>'height:20px;width: 270px;',
            'class'=>'input-text',
            'onfocus'=>"if(this.value == this.defaultValue) this.value = ''",
            'onblur'=>"if(this.value.replace(' ','') == '') this.value = this.defaultValue;",
        ),
  ));?>
  </div>
</div>
</body>
</html>