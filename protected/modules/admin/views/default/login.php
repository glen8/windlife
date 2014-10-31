<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="jsjgjf@qq.com" />
<title>登录 - <?php echo Yii::app()->name?>网站管理系统</title>
</head>

<body onload="javascript:document.getElementById('AdminLoginForm_username').focus();">
<div id="login">
  <div class="login_form">
    <?php echo CHtml::beginForm(Yii::app()->createUrl('admin/default/login'),'post',array('name'=>'myform')); ?>
      <label>用户名：</label>
      <?php echo CHtml::activeTextField($model,'username',array('class'=>'input')) ?>
      <label>密码：</label>
      <?php echo CHtml::activePasswordField($model,'password',array('class'=>'input')) ?>
      <label>验证码：</label>
      <?php echo CHtml::activeTextField($model,'verifyCode',array('class'=>'input imgcode','onfocus'=>"document.getElementById('show_imgcode').style.display='block'")) ?>
      <?php echo CHtml::submitButton(' ',array('class'=>'button','name'=>'dosubmit')); ?>
      <div id="show_imgcode">
        <?php $this->widget('CCaptcha',array('clickableImage'=>true,'buttonLabel'=>'单击更换验证码','imageOptions'=>array('class'=>'cursor'))); ?>
      </div>
    <?php echo CHtml::endForm(); ?>
  </div>
  <div class="copyright">Copyright &copy; <?php echo date('Y'); ?> <?php echo Yii::app()->name; ?></div>
</div>
</body>
</html>