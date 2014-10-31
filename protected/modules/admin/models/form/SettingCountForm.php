<?php

class SettingCountForm extends AdminFormModel
{
	public $code;


	public function rules()
	{
		return array(
			array('code','safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'code'=>'统计代码',
		);
	}

}
