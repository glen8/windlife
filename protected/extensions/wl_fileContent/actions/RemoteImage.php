<?php

class RemoteImage extends CAction{
	
	public function run(){
		if(isset($_POST[ 'upfile' ])){
			$title = htmlspecialchars($_POST['pictitle'], ENT_QUOTES);
			Yii::app()->cacheManage->cacheName='SettingCache';
			$setting_cache=Yii::app()->cacheManage->findCache();
			$setting_upload=unserialize($setting_cache['upload']['value']);
		    $config = array(
				"savePath" =>  htmlspecialchars( $_POST[ 'image_path' ] ),            //保存路径
				"allowFiles" => array('jpg','jpeg','png','gif','bmp') , //文件允许格式
				"maxSize" => $setting_upload['size']                    //文件大小限制，单位KB
		    );
		    $uri = htmlspecialchars( $_POST[ 'upfile' ] );
		    $uri = str_replace( "&amp;" , "&" , $uri );
		    $this->getRemoteImage( $uri,$config );
		}
	}
	
	private function getRemoteImage( $uri,$config)	{
		//忽略抓取时间限制
		set_time_limit( 0 );
		//ue_separate_ue  ue用于传递数据分割符号
		$imgUrls = explode( "ue_separate_ue" , $uri );
		$tmpNames = array();
		foreach ( $imgUrls as $imgUrl ) {
			//http开头验证
			if(strpos($imgUrl,"http")!==0){
				array_push( $tmpNames , "error" );
				continue;
			}
			//获取请求头
			$heads = get_headers( $imgUrl , 1);
			//死链检测
			if ( !( stristr( $heads[ 0 ] , "200" ) && stristr( $heads[ 0 ] , "OK" ) ) ) {
				array_push( $tmpNames , "error" );
				continue;
			}
			//格式验证(扩展名验证和Content-Type验证)
			$fileType = strtolower( strrchr( $imgUrl , '.' ) );
			if ( !in_array( $fileType , $config[ 'allowFiles' ] ) || !stristr( $heads[ 'Content-Type' ] , "image" ) ) {
				array_push( $tmpNames , "error" );
				continue;
			}
			//打开输出缓冲区并获取远程图片
			ob_start();
			$context = stream_context_create(
				array (
					'http' => array (
						'follow_location' => false // don't follow redirects
				    )
			    )
			);
			//请确保php.ini中的fopen wrappers已经激活
			readfile( $imgUrl,false,$context);
			$img = ob_get_contents();
			ob_end_clean();
			//大小验证
			$uriSize = strlen( $img ); //得到图片大小
			$allowSize = 1024 * $config[ 'maxSize' ];
			if ( $uriSize > $allowSize ) {
				array_push( $tmpNames , "error" );
				continue;
			}

			//写入文件
			$tmpName = $this->getFolder($config[ 'savePath' ]) . '/' . time()  . rand( 1 , 10000 ) . strrchr( $imgUrl , '.' );
			
			
			try {
				$fp2 = @fopen( $tmpName , "a" );
				fwrite( $fp2 , $img );
				fclose( $fp2 );
				$newTmpName=substr($tmpName, 1);
				array_push( $tmpNames ,  $newTmpName );
			} catch ( Exception $e ) {
				array_push( $tmpNames , "error" );
			}
			
			$attachment=new Attachment();
			$attachment->filename=substr(strrchr($tmpName, '/'), 1);$tmpName;
			$attachment->filepath=$tmpName;
			$attachment->fileext=strrchr( $tmpName , '.' );
			$attachment->filedesn=substr(substr(strrchr($tmpName, '/'), 1), 0, strpos(substr(strrchr($tmpName, '/'), 1), '.'));;
			$attachment->userid=isset(Yii::app()->user->id)&&is_int(Yii::app()->user->id)?Yii::app()->user->id:0;
			$attachment->filesize=filesize($tmpName);
			$attachment->isimage=1;
			$attachment->isremote=1;
			$attachment->uploadtime=date('U');
			$attachment->uploadip=Yii::app()->request->userHostAddress;
			$attachment->save(false);
		}
		/**
		 * 返回数据格式
		 * {
		 *   'url'   : '新地址一ue_separate_ue新地址二ue_separate_ue新地址三',
		 *   'srcUrl': '原始地址一ue_separate_ue原始地址二ue_separate_ue原始地址三'，
		 *   'tip'   : '状态提示'
		 * }
		 */
		echo "{'url':'" . implode( "ue_separate_ue" , $tmpNames ) . "','tip':'远程图片抓取成功！','srcUrl':'" . $uri . "'}";
	}
	
	private function getFolder($savePath)
	{
		$pathStr = $savePath;
		if ( strrchr( $pathStr , "/" ) != "/" ) {
			$pathStr .= "/";
		}
		$pathStr .= date( "Ymd" );
		if ( !file_exists( $pathStr ) ) {
			if ( !mkdir( $pathStr , 0777 , true ) ) {
				return false;
			}
		}
		return $pathStr;
	}
}

?>