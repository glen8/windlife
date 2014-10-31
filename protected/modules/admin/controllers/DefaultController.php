<?php

class DefaultController extends AdminController
{
	
	//后台主页
	public function actionIndex()
	{
		$this->layout=false;
		Yii::app()->cacheManage->cacheName='MenuCache';
		$menu_cache=Yii::app()->cacheManage->findCache();
		$tree=new Tree();
		$tree->init($menu_cache);
		$data ['top_menu']=$tree->get_child(0);
		$data['init_left_menu']=$tree->get_child(1);
		foreach ($data['init_left_menu'] as $k=>$v){
			if($tree->get_child($k)){
				$data['init_left_menu'][$k]['child_array']=$tree->get_child($k);
			}
		}
		$data ['admin_panels'] = AdminPanel::model()->findAllByAttributes(array('userid'=>Yii::app()->user->id));
		$this->render('index',$data);
	}
	
	//登陆
	public function actionLogin(){
		$this->layout=false;
		//清除锁屏信息
		if(isset(Yii::app()->session['lock_screen_username'])){
			unset(Yii::app()->session['lock_screen_username']);
		}
		if (Yii::app()->user->getId() !== null) {
			$this->redirectMessage("您已成功登录！", Yii::app()->createUrl($this->redirect_url.'index'));
		}
		$model=new AdminLoginForm();
		if(isset($_POST['dosubmit'])){
			if(empty($_POST['AdminLoginForm']['username'])){
				$this->redirectMessage("请输入用户名！", Yii::app()->createUrl($this->redirect_url.'login'),'warning');				
			}
			if(empty($_POST['AdminLoginForm']['password'])){
				$this->redirectMessage("请输入密码！", Yii::app()->createUrl($this->redirect_url.'login'),'warning');
			}
			if(empty($_POST['AdminLoginForm']['verifyCode'])){
				$this->redirectMessage("请输入验证码！", Yii::app()->createUrl($this->redirect_url.'login'),'warning');
			}
			$model->attributes=$_POST['AdminLoginForm'];
			if($model->validate() && $model->login()){
				$this->redirectMessage("登录成功！", Yii::app()->createUrl($this->redirect_url.'index'));
			}
			else{
				$message_code='';
				if(isset($model->errors['verifyCode'][0])){
					$message_code=$model->errors['verifyCode'][0];
				}
				$message_password='';
				if(isset($model->errors['password'][0])){
					$message_password=$model->errors['password'][0];
				}
				$this->redirectMessage($message_password.' '.$message_code, Yii::app()->createUrl($this->redirect_url.'login'),'warning');
			}
		}
		$this->render('login',array('model'=>$model));
	}
	
	//退出
	public function actionLogout()
	{
		Yii::app()->user->logout(false);
		$this->redirectMessage("退出登录成功！", Yii::app()->createUrl($this->redirect_url.'login'));
	}
	
	//锁屏处理
	public function actionLockScreen(){
		if(Yii::app()->request->isAjaxRequest){
			Yii::app()->session['lock_screen_username']=Yii::app()->user->name;
		    Yii::app()->user->logout(false);
		    echo '1';
		}
	}
	
	//锁屏登陆
	public function actionLockScreenLogin(){
		if(Yii::app()->request->isAjaxRequest){
	        if(isset(Yii::app()->session['lock_screen_username'])){
	        	$identity=new AdminIdentity(Yii::app()->session['lock_screen_username'],$_POST['password']);
	        	if($identity->lockAuthenticate()){
	        		Yii::app()->user->login($identity);
	        		unset(Yii::app()->session['lock_screen_username']);
	        		echo '1';
	        	}
	        	else{
	        		echo '-1';
	        	}	    	    
	        }
	        else {
	    	    echo '0';
	        }
		}
	}
	
	//关于我们
	public function actionAbout(){
		$this->layout=false;
		$this->render("about");
	}
	
	//后台内容首页
	public function actionMain(){
		$this->breadcrumbs='当前位置：我的面板 &gt;';
		if (get_cfg_var ( "file_uploads" )) {
			$max_size = get_cfg_var ( "upload_max_filesize" );
			$server_upload_status = "允许/最大 $max_size";
		} else {
			$server_upload_status = "不允许上传附件";
		}
		$data ['admin_panels'] = AdminPanel::model()->findAllByAttributes(array('userid'=>Yii::app()->user->id));
		$data ['upload_size'] = $server_upload_status;
		$this->menu_name='';
		$this->menu_url='';
		$this->render("main",$data);
	}
	
	// 左侧菜单
	public function actionLeftMenu() {
		if (Yii::app ()->request->isAjaxRequest) {
			if (isset ( $_GET ['parent_id'] )&& !empty($_GET ['parent_id'])) {
				Yii::app()->cacheManage->cacheName='MenuCache';
				$menu_cache=Yii::app()->cacheManage->findCache();
				$tree=new Tree();
				$tree->init($menu_cache);
				$left_menu=$tree->get_child((int)$_GET['parent_id']);
				$left_menu_str='';
				foreach ($left_menu as $k=>$v){
					if($v['display']==0)continue;
					$left_menu_str.='<h3><span title="展开与收缩" class="cursor"></span>'.$v['name'].'</h3>';
					if($tree->get_child($k)){
						$left_menu_str.='<ul>';
						foreach ($tree->get_child($k) as $k1=>$v1){
							if($v1['display']==0||$v1['display']==6||$v1['display']==7)continue;
							$params=Util::param2array($v1['data']);
							$left_menu_url=!empty($params)?Yii::app()->createUrl($v1['m'].'/'.$v1['c'].'/'.$v1['a'],Util::param2array($v1['data']))
							:Yii::app()->createUrl($v1['m'].'/'.$v1['c'].'/'.$v1['a']);
							$left_menu_str.=$v1['display']=='4'?"<li><a href=\"{$left_menu_url}\" target=\"center\" rel=\"iframe_center\">{$v1['name']}</a></li>"
							:"<li><a href=\"{$left_menu_url}\" target=\"main\">{$v1['name']}</a></li>";				
						}
						$left_menu_str.='</ul>';
					}
					
				}
				echo $left_menu_str;
			}
		}
	}
	
	//更新所有缓存
	public function actionUpdateCache(){
		$cache_list=array(
			array('name'=>'MenuCache','message'=>'后台管理菜单缓存更新成功'),
			array('name'=>'SettingCache','message'=>'网站配置信息缓存更新成功'),
			array('name'=>'ModelCache','message'=>'模型信息缓存更新成功'),
			array('name'=>'ContentCache','message'=>'内容栏目信息缓存更新成功'),				
			array('name'=>'UrlruleCache','message'=>'URL规则缓存更新成功'),
			array('name'=>'CopyfromCache','message'=>'信息来源记录缓存更新成功'),
			array('name'=>'BadwordCache','message'=>'敏感词记录缓存更新成功'),
			array('name'=>'ColumnParamCache','message'=>'栏目配置参数缓存更新成功'),
			array('name'=>'PositionCache','message'=>'发布位缓存更新成功'),
			array('name'=>'AdvertCache','message'=>'广告数据缓存更新成功'),
			array('name'=>'ReleaseCache','message'=>'内容发布版位数据缓存更新成功')
		);
		$data=array();
		if(!isset($_GET['step'])){
			$data['step_url']=Yii::app()->createUrl('admin/default/updateCache',array('step'=>0));
		}
		else{
			$step=(int)$_GET['step'];
			if(Yii::app ()->request->isAjaxRequest){
				$step_info=array();
				if(isset($cache_list[$step])){
					Yii::app()->cacheManage->cacheName=$cache_list[$step]['name'];
					Yii::app()->cacheManage->UpdateCache();
					$step_info['message']=$cache_list[$step]['message'];
					$step_info['next_step_url']=Yii::app()->createUrl('admin/default/updateCache',array('step'=>$step+1));
				}
				echo CJSON::encode($step_info);
				Yii::app()->end();		
			}
		}
		$this->render('updateCache',$data);
	}
	
	//底部快捷方式删除
	public function actionPanelDel(){
		if (Yii::app ()->request->isAjaxRequest){
			if(isset($_POST['panel_id'])&&(int)$_POST['panel_id']>0){
				AdminPanel::model()->deleteByPk((int)$_POST['panel_id']);
				echo '1';
			}
		}
	}
	
	//底部快捷方式添加
	public function actionPanelCreate(){
		if (Yii::app ()->request->isAjaxRequest){
			if(!empty($_POST['menu_name'])&&!empty($_POST['menu_url'])){						
				$is_menu=AdminPanel::model()->findByAttributes(array('name'=>$_POST['menu_name'],'url'=>$_POST['menu_url'],'userid'=>Yii::app()->user->id));
				if($is_menu==null){					
					$adminPanel=new AdminPanel();					
					$adminPanel->userid=Yii::app()->user->id;
					$adminPanel->name=$_POST['menu_name'];
					$adminPanel->url=$_POST['menu_url'];
					$adminPanel->datetime=date('U');
					$adminPanel->save(false);
					$panel_del_url=Yii::app()->createUrl('admin/default/PanelDel');
					echo "<span><a href=\"{$adminPanel->url}\" target=\"main\">{$adminPanel->name}</a><a class=\"panel_delete cursor\" val=\"{$adminPanel->id}\" rel=\"{$panel_del_url}\"><em>删除</em></a></span>";					
				}
				else{
					echo '0';
				}				
			}
			else{
				echo '0';
			}
		}
		else{
			echo '0';
		}
	}
	
	
	//错误处理
	public function actionError() {
		if (Yii::app ()->errorHandler->error) {
			$error = Yii::app ()->errorHandler->error;
			if (Yii::app ()->request->isAjaxRequest){				
				echo $error ['message'];
			}
			else{
				$this->layout=false;
				$this->render ( 'error', $error );
			}
		}
	}
	
	
	public function filters(){
		return array(
			'accessControl',
		);
	}
	
	public function accessRules(){
		return array(
			array('allow',
				'actions'=>array('login','captcha','lockScreenLogin','error'),
				'users'=>array('*'),
			),
			array('allow',
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*')
			),
		);
	}
	
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'application.components.extenders.CaptchaAction',
				'backColor'=>0xEDF7FF,
				'width' => '130',
				'padding' => '0',
				'maxLength'=>4,
				'minLength'=>4,
				'offset'=> -5,
				'testLimit'=>10,
			),
		);
	}
	
}