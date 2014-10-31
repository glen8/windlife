<?php
class Tips extends CWidget{
	
	public $message='';
	
	public function run(){
		$str='<div id="tips">温馨提示：'.$this->message.'</div>';
		echo $str;
	}
}
?>