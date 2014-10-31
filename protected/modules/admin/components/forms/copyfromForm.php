<?php
return array(
	'id'=>'copyfrom_form',
	'elements'=>array(
		'copyfrom'=>array(
			'type'=>'form',
			'title'=>'来源信息',			
			'elements'=>array(
	    		'sitename'=>array(
					'type'=>'text',
	    			'class'=>'input-text',
	    			'size'=>'25',
	    			'hint'=>'必填项',
				),				
				'siteurl'=>array(
					'type'=>'text',
	    			'class'=>'input-text',
	    			'size'=>'25',
	    			'hint'=>'必填项',
				),
				'thumb'=>array(
					'type'=>'application.extensions.wl_fileContent.WLImageUpload',
					'htmlOptions'=>array('class'=>'input-text','size'=>'40'),
				),
				'is_default'=>array(
					'type'=>'checkbox',
					'class'=>'input-checkbox',
					'size'=>'50',
				),
			),
		),
	),
	'buttons'=>array(
		'copyfrom_form_button'=>array(
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