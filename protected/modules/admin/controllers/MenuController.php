<?php

class MenuController extends AdminController
{
	//扩展：菜单列表
	public function actionIndex(){
		$tree=new Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$menu_list=Menu::model()->order('listorder ASC,id ASC')->findAll();
		$menu_array=array();
		foreach ($menu_list as $k=>$v){
			$menu_array[$k]['id']=$v->id;
			$menu_array[$k]['parentid']=$v->parent_id;
			$menu_array[$k]['name']=$v->name;
			$menu_array[$k]['listorder']=$v->listorder;
			$delete_url=CHtml::link('删除',array('/admin/menu/delete','id'=>$v->id),array('submit'=>array('/admin/menu/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->name.' 』 吗？'));
			$menu_array[$k]['str_manage'] = '<a href="'.Yii::app()->createUrl('admin/menu/create',array('parent_id'=>$v->id)).'">添加子菜单</a> | <a href="'.Yii::app()->createUrl('admin/menu/update',array('id'=>$v->id)).'">修改</a> | '.$delete_url;				
		}
		$str  = "<tr>
					<td align='center'><input name='listorders[\$id]' type='text' size='2' value='\$listorder' class='input-text-c input-text'></td>
					<td align='center'>\$id</td>
					<td >\$spacer\$name</td>
					<td align='center'>\$str_manage</td>
				</tr>";
		$tree->init($menu_array);
		$data['menu_str'] = $tree->get_tree(0, $str);
		$this->render('index',$data);
	}
	
	//扩展：添加菜单
	public function actionCreate(){
		$form=new CForm('application.modules.admin.components.forms.menuForm');
		$form['menu']->model=new Menu();
		if(isset($_GET['parent_id'])&&(int)$_GET['parent_id']>0){
			$form['menu']->model->parent_id=(int)$_GET['parent_id'];
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu_form'){
			echo CActiveForm::validate($form['menu']->model);
			Yii::app()->end();
		}
		if($form->submitted('menu_form_button') && $form->validate()){
			$menu=$form['menu']->model;
			if($menu->save(false)){
				$this->redirectMessage("菜单添加保存成功！", Yii::app()->createUrl('admin/menu/index'),'success');
			}
		}	
		$this->render('create',array('form'=>$form));
	}
	
	public function actionUpdate(){
		if(!isset($_GET['id'])&&empty($_GET['id'])){
			throw new CHttpException(404,'此信息不存在');
		}
		$menu_info=Menu::model()->findByPk((int)$_GET['id']);
		if($menu_info===null){
			throw new CHttpException(404,'此信息不存在');
		}
		$form=new CForm('application.modules.admin.components.forms.menuForm');
		$form['menu']->model=$menu_info;
		if($form->submitted('menu_form_button') && $form->validate()){
			$menu=$form['menu']->model;
			if($menu->save(false)){
				$this->redirectMessage("菜单修改保存成功！", Yii::app()->createUrl('admin/menu/index'),'success');
			}
		}
		$this->render('create',array('form'=>$form));
	}
	
	public function actions()
	{
		return array(
			'delete' => array(
				'class'      => 'application.modules.admin.components.actions.DeleteAction',
				'modelClass' => 'Menu',
				'message'    => array('success'=>'菜单删除成功！','warning_child'=>'无法删除存在子菜单项的菜单！'),
				'isHasChild' => array('ChildModelClass'=>'Menu','ChildModelField'=>'parent_id'),
				'redirectTo' => 'admin/menu/index',
			),
			'listorder' => array(
				'class'      => 'application.modules.admin.components.actions.ListorderAction',
				'modelClass' => 'Menu',
				'redirectTo' => 'admin/menu/index',
			),
		);
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	
}