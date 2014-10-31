<?php
class AdvertController extends AdminController {
	
	public function actionIndex() {
		$data['models']=Advert::model()->findAll();
		$data['ad_array']=$this->__getTemplets();
		Yii::app()->cacheManage->cacheName='PositionCache';
		$data['position_cache']=Yii::app()->cacheManage->findCache();
		$this->render ( 'index', $data);
	}
	
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.advertForm');
		$form['advert']->model=new Advert();
		$connection=Yii::app()->db;
		$sql="SELECT * FROM {{position}} WHERE key_name NOT IN(SELECT position_key FROM {{advert}}) AND type=1";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$form['advert']->elements['position_key']->items=CHtml::listData($dataReader, 'key_name', 'description');
		$form['advert']->elements['ad_key']->items=CHtml::listData($this->__getTemplets(), 'key', 'title');
		if(isset($_POST['ajax']) && $_POST['ajax']==='advert_form'){
			echo CActiveForm::validate($form['advert']->model);
			Yii::app()->end();
		}
		if($form->submitted('advert_form_button') && $form->validate()){
			$advert=$form['advert']->model;
			if($advert->save(false)){
				$this->redirectMessage("广告位添加保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$advert_info=Advert::model()->findByPk((int)$_GET['id']);
		if($advert_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.advertForm');
		$form['advert']->model=$advert_info;
		$connection=Yii::app()->db;
		$sql="SELECT * FROM {{position}} WHERE type=1";
		$command=$connection->createCommand($sql);
		$dataReader=$command->queryAll();
		$form['advert']->elements['position_key']->items=CHtml::listData($dataReader, 'key_name', 'description');
		$form['advert']->elements['ad_key']->items=CHtml::listData($this->__getTemplets(), 'key', 'title');
		$form['advert']->elements['position_key']->attributes=array('disabled'=>'disabled');
		if($advert_info->num>0){
			$form['advert']->elements['ad_key']->attributes=array('disabled'=>'disabled');
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='advert_form'){
			echo CActiveForm::validate($form['advert']->model);
			Yii::app()->end();
		}
		if($form->submitted('advert_form_button') && $form->validate()){
			$advert=$form['advert']->model;
			if($advert->save(false)){
				$this->redirectMessage("版位修改保存成功！", Yii::app()->createUrl($this->redirect_url.'index'),'success',3 ,'<script>setTimeout(\'window.top.main.location.reload()\',500);</script>');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actionList(){
		if(!isset($_GET['ad_id'])&&empty($_GET['ad_id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$data['ad_id']=(int)$_GET['ad_id'];
		$data['models']=AdvertItem::model()->order('listorder ASC,id ASC')->findAllByAttributes(array('ad_id'=>(int)$_GET['ad_id']));
		$data['ad_array']=$this->__getTemplets();
		Yii::app()->cacheManage->cacheName='PositionCache';
		$position_cache=Yii::app()->cacheManage->findCache();
		$advert_info=Advert::model()->findByPk((int)$_GET['ad_id']);
		$data['position']=isset($position_cache[1][$advert_info->position_key])?$position_cache['1'][$advert_info->position_key]:$advert_info->position_key;
		$data['position_cache']=$position_cache;
		$this->render ( 'list', $data);		
	}
	
	public function actionAdd(){		
		if(!isset($_GET['ad_id'])&&empty($_GET['ad_id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$num=AdvertItem::model()->countByAttributes(array('ad_id'=>(int)$_GET['ad_id']));
		$advert_info=Advert::model()->findByPk((int)$_GET['ad_id']);
		$ad_array=$this->__getTemplets();
		$max_num=isset($ad_array[$advert_info->ad_key])?$ad_array[$advert_info->ad_key]['max_num']:0;
		Yii::app()->cacheManage->cacheName='PositionCache';
		$position_cache=Yii::app()->cacheManage->findCache();
		$position_info=isset($position_cache[1][$advert_info->position_key])?$position_cache['1'][$advert_info->position_key]:$advert_info->position_key;
		if($num>=$max_num){
			throw new CHttpException(404,'广告数量已达模板最大数量，不能添加');
		}
		$form=new CForm('application.modules.admin.components.forms.advertItemForm');
		$advert_item=new AdvertItem();
		$advert_item->ad_id=(int)$_GET['ad_id'];
		$form['advert_item']->model=$advert_item;
		if(isset($ad_array[$advert_info->ad_key])&&$ad_array[$advert_info->ad_key]['type']!='image'){
		    $form['advert_item']->elements['file_url']->type='application.extensions.wl_fileContent.WLFileUpload';
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='advert_item_form'){
			echo CActiveForm::validate($form['advert_item']->model);
			Yii::app()->end();
		}
		if($form->submitted('advert_item_form_button') && $form->validate()){
			$advert_item=$form['advert_item']->model;
			if($advert_item->save(false)){
				$this->redirectMessage("广告添加保存成功！", Yii::app()->createUrl($this->redirect_url.'list',array('ad_id'=>(int)$_GET['ad_id'])),'success');
			}
		}
		$this->render('add',array('form'=>$form,'position'=>$position_info));
	}
	
	public function actionEdit(){
		if(!isset($_GET['ad_id'])&&empty($_GET['ad_id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$advert_item_info=AdvertItem::model()->findByPk((int)$_GET['id']);
		if($advert_item_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$advert_info=Advert::model()->findByPk((int)$_GET['ad_id']);
		Yii::app()->cacheManage->cacheName='PositionCache';
		$position_cache=Yii::app()->cacheManage->findCache();
		$position_info=isset($position_cache[1][$advert_info->position_key])?$position_cache['1'][$advert_info->position_key]:$advert_info->position_key;
		
		$form=new CForm('application.modules.admin.components.forms.advertItemForm');
		$form['advert_item']->model=$advert_item_info;
		if(isset($ad_array[$advert_info->ad_key])&&$ad_array[$advert_info->ad_key]['type']!='image'){
			$form['advert_item']->elements['file_url']->type='application.extensions.wl_fileContent.WLFileUpload';
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='advert_item_form'){
			echo CActiveForm::validate($form['advert_item']->model);
			Yii::app()->end();
		}
		if($form->submitted('advert_item_form_button') && $form->validate()){
			$advert_item=$form['advert_item']->model;
			if($advert_item->save(false)){
				$this->redirectMessage("广告修改保存成功！", Yii::app()->createUrl($this->redirect_url.'list',array('ad_id'=>(int)$_GET['ad_id'])),'success');
			}
		}
		$this->render('add',array('form'=>$form,'position'=>$position_info));
	}
	
	public function actionCode(){
		$this->layout=false;
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$advert_info=Advert::model()->findByPk((int)$_GET['id']);
		if($advert_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		Yii::app()->cacheManage->cacheName='PositionCache';
		$position_cache=Yii::app()->cacheManage->findCache();
		$data['title']=isset($position_cache['1'][$advert_info->position_key])?$position_cache['1'][$advert_info->position_key]:$advert_info->position_key;
		$data['code']=htmlspecialchars("<?php echo PositionGet::get('{$advert_info->position_key}',1); ?>");
		$this->render('code',$data);
	}
	
	public function actionTemplet() {		
		$this->render('templet',array('ad_array'=>$this->__getTemplets()));
	}	
	
	public function actions()
	{
		return array(
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Advert',
				'message'    => array('success'=>'版位删除成功！','warning_biz'=>'无法删除,版位存在数据！'),
				'redirectTo' => 'admin/advert/index',
				'bizrule'    => '$is_judge=$model->num>0;',
			),
			'del' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'AdvertItem',
				'message'    => array('success'=>'广告删除成功！'),
				'redirectTo' => 'admin/advert/list',
				'redirectParam' => array('ad_id'=>isset($_GET['ad_id'])?(int)$_GET['ad_id']:0)
			),
			'deleteAll'=>array(
				'class'=>'application.modules.admin.components.actions.DeleteAllAction',
				'modelClass' => 'Advert',
				'message'    => array('success'=>'版位删除成功！','warning_biz'=>'删除版位中已有广告，尚未全部删除'),
				'redirectTo' => 'admin/advert/index',
				'bizrule'    => '$is_judge=$model->num>0;',
			),
			'imageManager'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageManager',
			),
			'imageUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.ImageUp',
			),
			'remoteImage'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.RemoteImage',
			),
			'fileUp'=>array(
				'class'=>'application.extensions.wl_fileContent.actions.FileUp',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'AdvertItem',
				'redirectTo' => 'admin/advert/list',
				'redirectParam' => array('ad_id'=>isset($_GET['ad_id'])?(int)$_GET['ad_id']:0)
			),
		);
	}
	
	private function __getTemplets(){
		$path = YiiBase::getPathOfAlias ( 'ext' ) . DIRECTORY_SEPARATOR .'wl_advert';
		$current_dir = opendir ( $path );
		$ad_array=array();
		while ( ($file = readdir ( $current_dir )) !== false ) {
			$sub_dir = $path . DIRECTORY_SEPARATOR . $file;
			if ($file == '.' || $file == '..'|| strstr($file,'.')) {
				continue;
			} else if (is_dir ( $sub_dir )) { // 如果是目录,进行递归
				$ad_array[$file]=require $sub_dir. DIRECTORY_SEPARATOR . 'config.php';
			}
		}
		return $ad_array;
	}
	
	public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
}