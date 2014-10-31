<?php

class SettingController extends AdminController
{
	public function actionIndex()
	{
		$form=new CForm('application.modules.admin.components.forms.settingForm');
		$form['base']->model=new SettingBaseForm();
		$setting_base=Setting::model()->findByPk('base');
		$form['base']->model->attributes=unserialize($setting_base->value);
		
		$form['upload']->model=new SettingUploadForm();
		$setting_upload=Setting::model()->findByPk('upload');
		$form['upload']->model->attributes=unserialize($setting_upload->value);
		
		$form['email']->model=new SettingEmailForm();
		$setting_email=Setting::model()->findByPk('email');
		$form['email']->model->attributes=unserialize($setting_email->value);
		
		$form['count']->model=new SettingCountForm();
		$setting_count=Setting::model()->findByPk('count');
		$form['count']->model->attributes=unserialize($setting_count->value);
		
		$data['form']=$form;
		$data['form_type']=isset($_POST['form_type'])?$_POST['form_type']:$_GET['form_type'];
		if($form->submitted('setting_form_button') && $form->validate()){
			$setting_object=${'setting_'.$data['form_type']};
			$values=$form[$data['form_type']]->model->attributes;
			if($data['form_type']=='email'){
				unset($values['test']);
			}
			$setting_object->value=serialize(array_filter($values));			
			if($setting_object->save(false)){
				$this->redirectMessage("设置保存成功！", Yii::app()->createUrl('admin/setting/index',array('form_type'=>$data['form_type'])),'success');
			}
		}
		$this->render('index',$data);
	}
	
    public function beforeAction($action){
		$this->wl_accessControl();
		return parent::beforeAction($action);
	}
	
}