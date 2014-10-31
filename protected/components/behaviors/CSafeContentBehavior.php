<?php
class CSafeContentBehavior extends CActiveRecordBehavior
{
	public $attributes =array();
	protected $purifier;

	function __construct(){
		$this->purifier = new CHtmlPurifier;
	}

	public function beforeSave($event){
		foreach($this->attributes as $attribute){
			$this->getOwner()->{$attribute} = $this->purifier->purify($this->getOwner()->{$attribute});
		}
		return parent::beforeSave($event);
	}
}
?>