<?php

class ColumnSeoForm extends AdminFormModel{
	
	public $metaTitle;
	public $metaKeyword;
	public $metaDescription;
	
	public function rules()
	{
		return array(
			array('metaTitle, metaKeyword, metaDescription', 'safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'metaTitle'=>'<strong>META Title（栏目标题）</strong><br />针对搜索引擎设置的标题',
			'metaKeyword'=>'<strong>META Keywords（栏目关键词）</strong><br />关键字中间用半角逗号隔开',
			'metaDescription'=>'<strong>META Description（栏目描述）</strong><br />针对搜索引擎设置的网页描述',
		);
	}
	
}

?>