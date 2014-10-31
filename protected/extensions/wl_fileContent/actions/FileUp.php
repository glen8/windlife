<?php

class FileUp extends CAction{
	
	public function run(){
		Yii::import('application.extensions.wl_fileContent.UploadHelper');
		Yii::app()->cacheManage->cacheName='SettingCache';
		$setting_cache=Yii::app()->cacheManage->findCache();
		$setting_upload=unserialize($setting_cache['upload']['value']);
		$config = array(
			"savePath" => htmlspecialchars($_POST['file_path']) , //保存路径
			"allowFiles" => explode('|', $setting_upload['fileType']) , //文件允许格式
			"maxSize" => $setting_upload['size'] //文件大小限制，单位KB
		);
		$up = new UploadHelper("upfile", $config);
		$info = $up->getFileInfo();
		
		$attachment=new Attachment();
		$attachment->filename=$info['originalName'];
		$attachment->filepath=$info["url"];
		$attachment->fileext=$info["type"];
		$attachment->filedesn=substr($info['originalName'], 0,strpos($info['originalName'],'.'));
		$attachment->userid=isset(Yii::app()->user->id)&&is_int(Yii::app()->user->id)?Yii::app()->user->id:0;
		$attachment->filesize=filesize($info["url"]);
		$attachment->uploadtime=date('U');
		$attachment->uploadip=Yii::app()->request->userHostAddress;
		$attachment->save(false);
		
		$ret_array=array(
			'url'=>substr($info["url"],1),
			'fileType'=>$info["type"],
			'original'=>$info["originalName"],
			'state'=>$info["state"]
		);
		
		echo CJSON::encode($ret_array);
	}
}

?>