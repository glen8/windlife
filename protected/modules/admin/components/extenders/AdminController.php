<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AdminController extends CController {
	
	public $menu_add;
	
	public $sub_nav;
	
	protected $redirect_url;	
	
	protected $breadcrumbs;
	
	public $menu_name;
	
	public $menu_url;
	
	public function beforeAction($action) {
		$this->redirect_url=Yii::app ()->controller->module->id.'/'.Yii::app ()->controller->id.'/';
		Yii::app()->cacheManage->cacheName='MenuCache';
		$menu_cache=Yii::app()->cacheManage->findCache();
		$tree=new Tree();
		$tree->init($menu_cache);
		$this_id=0;		
	    $key_param_str='';
		if(isset($_GET['form_type'])){
			$key_param_str='form_type='.$_GET['form_type'];
		}
		foreach ($menu_cache as $v){
			if(isset($_GET['form_type'])){
			    if($v['m']==Yii::app ()->controller->module->id&&$v['c']==Yii::app ()->controller->id&&$v['a']==Yii::app ()->controller->action->id&&$v['data']==$key_param_str){
				    $this_id=$v['id'];
				    break;
			    }    
			}
			else{
				if($v['m']==Yii::app ()->controller->module->id&&$v['c']==Yii::app ()->controller->id&&$v['a']==Yii::app ()->controller->action->id){
					$this_id=$v['id'];
					break;
				}
			}
		}
		if($this_id>0){	
			$begin_id=0;
			$tree::$level=1;    
		    $level=$tree->get_level($this_id);
		    if($level==3){
		    	$begin_id=$this_id;
			    $this->sub_nav[]=$menu_cache[$this_id];
			    foreach ($menu_cache as $v){
				    if($v['parentid']==$this_id){
					    $this->sub_nav[]=$v;
				    }
			    }
		    }
		    if($level==4){
		    	$begin_id=$menu_cache[$this_id]['parentid'];
			    $this->sub_nav[]=$menu_cache[$menu_cache[$this_id]['parentid']];
			    foreach ($menu_cache as $v){
				    if($v['parentid']==$menu_cache[$this_id]['parentid']){
					    $this->sub_nav[]=$v;
				    }				
			    }
		    }
		    if(count($this->sub_nav)>0){
		        foreach ($this->sub_nav as $v){
		    	    if($v['display']==2||$v['display']==3){
		    		    $this->menu_add=$v;
		    	    }
		        }
		    }
		    if($begin_id>0){
		    	$this->menu_name=$menu_cache[$begin_id]['name'];
		    	$params=Util::param2array($menu_cache[$begin_id]['data']);
		    	$this->menu_url=!empty($params)?Yii::app()->createUrl($menu_cache[$begin_id]['m'].'/'.$menu_cache[$begin_id]['c'].'/'.$menu_cache[$begin_id]['a'],Util::param2array($menu_cache[$begin_id]['data'])):Yii::app()->createUrl($menu_cache[$begin_id]['m'].'/'.$menu_cache[$begin_id]['c'].'/'.$menu_cache[$begin_id]['a']);
		    	$this->breadcrumbs=$menu_cache[$begin_id]['name'].' &gt;';
		    	$sub_menu=$menu_cache[$menu_cache[$begin_id]['parentid']];
		    	$this->breadcrumbs=$sub_menu['name'].' &gt; '.$this->breadcrumbs;
		    	$top_menu=$menu_cache[$sub_menu['parentid']];
		    	$this->breadcrumbs=$top_menu['name'].' &gt; '.$this->breadcrumbs;
		    }
		}
		return true;
	}
	
	
	public function redirectMessage($message, $url, $status='success', $delay=2, $script=''){
		$this->layout=false; 
		$this->render('application.modules.admin.views._layouts.message', 
			array(
				'message'=> $message,
				'url'=> $url,
				'status'=> $status,
				'delay'=> $delay,
				'script'=>$script,
			)
		);
		exit;
	}
	
	protected function wl_accessControl(){
		if(!Yii::app()->user->id){
			$this->redirectMessage("尚未登录，请登录！", Yii::app()->createUrl('admin/default/login'),'warning');
		}
		$itemName=Yii::app ()->controller->module->id.'_'.Yii::app ()->controller->id.'_'.Yii::app ()->controller->action->id;
		$params=array();
		$auth=Yii::app()->authManager;
		$access=$auth->getAuthItem($itemName);
		if(!empty($access)){
			$data=$access->getData();
			if(!empty($data)) @eval($data);
		}
		$role_name=Yii::app()->user->getAdminRoleName();
		if($role_name!==null&&$role_name!='SuperAdmin'&&!Yii::app()->user->checkAccess($itemName,$params)){
			throw new CHttpException(403,'您未被授权执行这个动作');
		}
	}
}