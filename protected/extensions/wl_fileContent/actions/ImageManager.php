<?php

class ImageManager extends CAction{
	
	public function run(){
		if($_POST['action']=='get'){
			$connection=Yii::app()->db;
			$command=$connection->createCommand()->select('filepath,filedesn')->from('{{attachment}}')->where('isimage=:isimage', array(':isimage'=>1))->order('id DESC');
			$dataReader=$command->query();
			$str = "";
			foreach ( $dataReader as $v ) {
				if(is_file($v['filepath'])){
				    $str .= substr($v['filepath'],1).'|'.$v['filedesn'] . "ue_separate_ue";
				}
			}
			echo $str;
		}
	}	
}

?>