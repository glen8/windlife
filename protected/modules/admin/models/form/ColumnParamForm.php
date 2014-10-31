<?php

class ColumnParamForm extends AdminFormModel{
	
	public $m;
	public $c;
	public $a;
	public $data;
	
	public function rules()
	{
		return array(
			array('c', 'required','message'=>'请输入控制器名称'),
			array('a', 'required','message'=>'请输入控制器方法名称'),
			array('m, data', 'safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'm'=>'模块名称',
			'c'=>'控制器名称',
			'a'=>'控制器方法名称',
			'data'=>'访问参数',
		);
	}
	
}

?>