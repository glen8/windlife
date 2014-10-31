<?php
return array(
	'id'=>'release_form',
	'elements'=>array(
		'release'=>array(
			'type'=>'form',
			'title'=>'内容发布信息',			
			'elements'=>array(
	    		'key_name'=>array(
	    			'type'=>'dropdownlist',
	    			'encode'=>false,
	    			'label'=>'选择位置'
				),				
				'title'=>array(
					'type'=>'text',
					'class'=>'input-text',
	    			'size'=>'25',
					'hint'=>'必填项'
				),
				'max_num'=>array(
					'type'=>'text',
					'class'=>'input-text',
	    			'size'=>'4',
					'hint'=>'内容发布栏目标题'
				),
				'model_id'=>array(
					'type'=>'dropdownlist',
	    			'encode'=>false,
					'prompt'=>'选择模型',
					'hint'=>'可绑定模型'
				),
				'first_title_length'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'10',
				),
				'first_desc_length'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'10',
				),
				'img_title_length'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'10',
				),
				'img_desc_length'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'10',
				),
				'img_size'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'10',
					'hint'=>'例如：200*200'
				),
				'other_title_length'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'10',
				),
				'other_desc_length'=>array(
					'type'=>'text',
					'class'=>'input-text',
					'size'=>'10',
				),
			),
		),
	),
	'buttons'=>array(
		'release_form_button'=>array(
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
			'validateOnChange'=>true,
			'afterValidateAttribute'=>'js:afterValidate',
		),
	),
);