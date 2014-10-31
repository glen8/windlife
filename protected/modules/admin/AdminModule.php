<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.data.*',
			'admin.models.form.*',
			'admin.components.extenders.*',
		));
		Yii::app()->setComponents(array(
		    'errorHandler' => array(
		        'class' => 'CErrorHandler',
		        'errorAction' => '/admin/default/error',
		    ),        
		    'user' => array(
		        'class' => 'application.modules.admin.components.extenders.AdminWebUser',
		        'stateKeyPrefix'=>'admin',
		        'allowAutoLogin' => false,
		        'loginUrl' => array('/admin/default/login'),
		    ),
		    'urlManager'=>array(
		    	'urlFormat'=>'get',
		    	'showScriptName'=>false,
		    ),
		    'clientScript'=>array(
		    	'class'=>'CClientScript',
		    	'scriptMap' => null,
		    ),
		), false);
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			$controller->layout = 'application.modules.admin.views._layouts.default_layout';
			Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/admin/style.css');
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/scripts/admin/function.js');
			return true;
		}
		else
			return false;
	}
}
