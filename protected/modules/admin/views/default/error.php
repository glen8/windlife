<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息 - <?php echo Yii::app()->name?>网站管理系统</title>
</head>

<body>
<div id="message">
  <h5>错误信息</h5>
  <div class="content error"><?php echo CHtml::encode($message); ?></div>
  <div class="bottom"></div>
</div>
</body>
</html>