<?php
return array(
	'id'=>'page_form',
	'elements'=>array(
		'page'=>array(
			'type'=>'form',
			'title'=>'单页面信息',			
			'elements'=>array(
	    		'title'=>array(
					'type'=>'application.extensions.wl_inputTitle.WLInputTitle',
	    			'styleAttribute'=>'style',
                    'imgCss'=>'cursor: pointer;float:left;margin-top:3px;',
                    'htmlOptions'=>array('class'=>'input-text measure-input','style'=>'width: 400px;'),
				),				
				'keyword'=>array(
					'type'=>'text',
	    			'class'=>'input-text',
	    			'size'=>'50',
	    			'hint'=>'多关键词之间用“,”隔开',
				),
				'content'=>array(
					'type'=>'application.extensions.wl_fileContent.WLEditor',
					'height'=>'300'
				),
			),
		),
	),
	'buttons'=>array(
		'page_form_button'=>array(
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