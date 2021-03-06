<?php
return array(
	'id'=>'column_link_form',
	'elements'=>array(
		'base'=>array(
			'type'=>'form',
			'title'=>'基本选项',			
			'elements'=>array(
				'parentid'=>array(
					'type'=>'dropdownlist',
					'items'=>Column::model()->wl_getColumnOption(),
					'prompt'=>'作为一级菜单',
					'encode'=>false,
				),
				'colname'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'30',
					'hint'=>'栏目名称为必填项，请填写'
				),				
				'image'=>array(
					'type'=>'application.extensions.wl_fileContent.WLImageUpload',
					'htmlOptions'=>array('class'=>'input-text','size'=>'50'),
				),
				'url'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'50',
					'hint'=>'链接地址为必填项，请填写'
				),
				'description'=>array(
					'type'=>'textarea',
					'class'=>'input-textarea',
					'style'=>'height: 60px;',
					'cols'=>'50',
				),
				'display'=>array(
					'type'=>'checkbox',
					'class'=>'input-checkbox',
				),
				'target'=>array(
					'type'=>'radiolist',
					'items'=>array('_self'=>'本窗口打开','_blank'=>'新建窗口打开'),
					'separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;',
					'class'=>'input-radio',
				),
			),
		),
	),
	'buttons'=>array(
		'column_link_form_button'=>array(
			'type'=>'submit',
			'label'=>'提交',
			'class'=>'button',
		),
	),
	'activeForm'=>array(
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
		'clientOptions' => array(
			'validateOnChange'=>true,
			'afterValidateAttribute'=>'js:afterValidate',
		),
	),
);