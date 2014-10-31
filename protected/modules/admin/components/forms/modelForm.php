<?php
return array(
	'id'=>'model_form',
	'elements'=>array(
		'base'=>array(
			'type'=>'form',
			'title'=>'模型信息',			
			'elements'=>array(
	    		'name'=>array(
					'type'=>'text',
	    			'class'=>'input-text',
	    			'hint'=>'此项为必填项，请填写'
				),
				'module'=>array(
					'type'=>'text',
					'class'=>'input-text'
				),
				'controller'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'hint'=>'此项为必填项，请填写'
				),
				'action'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'hint'=>'此项为必填项，请填写'
				),
				'object'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'hint'=>'此项为必填项，请填写'
				),
				'data'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'30',
					'hint'=>'为地址参数。格式：s=222&a=33',
				),
				'data_num'=>array(
					'type'=>'radiolist',
					'items'=>array('0'=>'一条','1'=>'多条'),
					'separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;',
					'class'=>'input-radio',
				),
			),
		),
		'manage'=>array(
			'type'=>'form',
			'title'=>'后台管理地址',
			'elements'=>array(
				'm_module'=>array(
					'type'=>'text',
					'class'=>'input-text'
				),
				'm_controller'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'hint'=>'此项为必填项，请填写'
				),
				'm_action'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'hint'=>'此项为必填项，请填写'
				),
				'm_data'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'30',
					'hint'=>'为地址参数。格式：s=222&a=33',
				),
			),
		),
	),
	'buttons'=>array(
		'model_form_button'=>array(
			'type'=>'submit',
			'label'=>'提交',
			'class'=>'button',
		),
	),
	'activeForm'=>array(
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions' => array(
			'validateOnChange'=>true,
			'afterValidateAttribute'=>'js:afterValidate',
		),
	),
);