<?php
return array(
	'id'=>'advert_form',
	'elements'=>array(
		'advert'=>array(
			'type'=>'form',
			'title'=>'版位信息',			
			'elements'=>array(
	    		'position_key'=>array(
					'type'=>'dropdownlist',
	    			'prompt'=>'请选择位置',
	    			'hint'=>'请选择位置',
				),				
				'ad_key'=>array(
					'type'=>'dropdownlist',
	    			'prompt'=>'请选择广告模板',
	    			'hint'=>'请选择广告模板',
				),
				'width'=>array(
					'type'=>'text',
	    			'class'=>'input-text',
					'hint'=>'单位为像素',
				),
				'height'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'hint'=>'单位为像素',
				),
				'style'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'hint'=>'直接书写css样式',
					'size'=>'40'
				),
				'description'=>array(
					'type'=>'textarea',
					'class'=>'input-textarea',
					'style'=>'height: 60px;',
					'cols'=>'50',
				),
			),
		),
	),
	'buttons'=>array(
		'advert_form_button'=>array(
			'type'=>'submit',
			'label'=>'提交',
			'class'=>'button',
			'id'=>'dosubmit',
		),
	),
	'activeForm'=>array(
		'enableAjaxValidation'=>true,
		'enableClientValidation'=>true,
		'clientOptions' => array(
			'validateOnSubmit'=>true,
			'afterValidateAttribute'=>'js:afterValidate',
		),
	),
);