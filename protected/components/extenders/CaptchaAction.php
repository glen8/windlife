<?php

class CaptchaAction extends CCaptchaAction {
	
	public function run()
	{
		if(isset($_GET[self::REFRESH_GET_VAR]))  // AJAX request for regenerating code
		{
			$code=$this->getVerifyCode(true);
			echo CJSON::encode(array(
					'hash1'=>$this->generateValidationHash($code),
					'hash2'=>$this->generateValidationHash(strtolower($code)),
					// we add a random 'v' parameter so that FireFox can refresh the image
					// when src attribute of image tag is changed
					'url'=>$this->getController()->createUrl($this->getId(),array('v' => uniqid())),
			));
		}
		else
			$this->renderImage($this->getVerifyCode(true));
		Yii::app()->end();
	}
	
}

?>