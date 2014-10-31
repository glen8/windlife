<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="jsjgjf@qq.com" />
<title><?php echo Yii::app()->name?> 网站信息管理系统</title>
</head>

<body class="layout<?php if(isset($this->bady_class)) echo ' '.$this->bady_class;?>">
<input id="breadcrumbs" value="<?php echo $this->breadcrumbs;?>" type="hidden" /> 
<input id="menu_name" value="<?php echo $this->menu_name;?>" type="hidden" />
<input id="menu_url" value="<?php echo $this->menu_url;?>" type="hidden" />
<?php echo $content; ?>
</body>
</html>