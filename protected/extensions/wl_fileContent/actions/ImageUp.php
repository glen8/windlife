<?php

class ImageUp extends CAction{
	
	public function run(){
		Yii::import('application.extensions.wl_fileContent.UploadHelper');
		$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
		Yii::app()->cacheManage->cacheName='SettingCache';
		$setting_cache=Yii::app()->cacheManage->findCache();
		$setting_upload=unserialize($setting_cache['upload']['value']);
		$config = array(
			"savePath" => htmlspecialchars($_POST['image_path']),
			"maxSize" => $setting_upload['size'], //单位KB
			"allowFiles" => array('jpg','jpeg','png','gif','bmp')
		);
		
		$up = new UploadHelper("upfile", $config);
		
		$info = $up->getFileInfo();
		
		$attachment=new Attachment();
		$attachment->filename=$info['originalName'];
		$attachment->filepath=$info["url"];
		$attachment->fileext=strrchr( $info["url"] , '.' );
		$attachment->filedesn=strpos($title,'.')>0?substr($title, 0,strpos($title,'.')):$title;
		$attachment->userid=isset(Yii::app()->user->id)&&is_int(Yii::app()->user->id)?Yii::app()->user->id:0;
		$attachment->filesize=filesize($info["url"]);
		$attachment->isimage=1;
		$attachment->uploadtime=date('U');
		$attachment->uploadip=Yii::app()->request->userHostAddress;
		$attachment->save(false);
		
		$ret_array=array(
			'url'=>substr($info["url"],1),
			'title'=>$attachment->filedesn,
			'original'=>$info["originalName"],
			'state'=>$info["state"]
		);
		
		echo CJSON::encode($ret_array);
	}
}

?>