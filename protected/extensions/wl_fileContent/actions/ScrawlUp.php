<?php

class ScrawlUp extends CAction{
	
	public function run(){
		Yii::import('application.extensions.wl_fileContent.UploadHelper');
		Yii::app()->cacheManage->cacheName='SettingCache';
		$setting_cache=Yii::app()->cacheManage->findCache();
		$setting_upload=unserialize($setting_cache['upload']['value']);
		$config = array(
			"savePath" => htmlspecialchars($_POST['image_path']) ,             //存储文件夹
			"maxSize" => $setting_upload['size'] ,                   //允许的文件最大尺寸，单位KB
			"allowFiles" => array('jpg','jpeg','png','gif','bmp')  //允许的文件格式
		);
		
		$tmpPath = htmlspecialchars($_POST['image_path'])."/tmp/";
		
		//获取当前上传的类型
		if (isset($_GET[ "action" ]) && htmlspecialchars($_GET[ "action" ]) == "tmpImg" ) { // 背景上传
			//背景保存在临时目录中
			$config[ "savePath" ] = $tmpPath;
			$up = new UploadHelper( "upfile" , $config );
			$info = $up->getFileInfo();

			echo "<script>parent.ue_callback('" . substr($info[ "url" ],1) . "','" . $info[ "state" ] . "')</script>";
		} else {
			//涂鸦上传，上传方式采用了base64编码模式，所以第三个参数设置为true
			$up = new UploadHelper( "content" , $config , true );
			//上传成功后删除临时目录
			if(file_exists($tmpPath)){
				$this->delDir($tmpPath);
			}
			$info = $up->getFileInfo();
			
			$attachment=new Attachment();
			$attachment->filename=substr(strrchr($info["url"], '/'), 1);
			$attachment->filepath=$info["url"];
			$attachment->fileext=strrchr( $info["url"] , '.' );
			$attachment->filedesn=substr(substr(strrchr($info["url"], '/'), 1), 0, strpos(substr(strrchr($info["url"], '/'), 1), '.'));
			$attachment->userid=isset(Yii::app()->user->id)&&is_int(Yii::app()->user->id)?Yii::app()->user->id:0;
			$attachment->filesize=filesize($info["url"]);
			$attachment->isimage=1;
			$attachment->isscrawl=1;
			$attachment->uploadtime=date('U');
			$attachment->uploadip=Yii::app()->request->userHostAddress;
			$attachment->save(false);
			
			$ret_array=array(
					'url'=>substr($info["url"],1),
					'state'=>$info["state"]
			);
			
			echo CJSON::encode($ret_array);
		}
	}
	
	private function delDir( $dir )
	{
		//先删除目录下的所有文件：
		$dh = opendir( $dir );
		while ( $file = readdir( $dh ) ) {
			if ( $file != "." && $file != ".." ) {
				$fullpath = $dir . "/" . $file;
				if ( !is_dir( $fullpath ) ) {
					unlink( $fullpath );
				} else {
					$this->delDir( $fullpath );
				}
			}
		}
		closedir( $dh );
		//删除当前文件夹：
		return rmdir( $dir );
	}
}

?>