<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="index_html">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="jsjgjf@qq.com" />
<title><?php echo Yii::app()->name?> 后台管理系统</title>
</head>

<body class="index">
<input type="hidden" id="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken; ?>" />
<input type="hidden" id="content_find_column_url" value="<?php echo Yii::app()->createUrl('admin/content/findColumn'); ?>" /> 
<div id="index_lock_screen" style="display: none">
  <div class="content">
    <h5>锁屏状态，请输入密码解锁</h5>
    <div class="form">
      <label>密码：</label><input type="password" id="lock_password" class="input_text" size="20" />
      <input type="submit" class="submit" value="&nbsp;" rel="locklogin" url="<?php echo Yii::app()->createUrl('admin/default/lockScreenLogin')?>" name="dosubmit" />
    </div>
  </div>
</div>
<div id="index_header">
  <div class="logo"><a href="<?php echo Yii::app()->createUrl('admin/default/index')?>"><?php echo Yii::app()->name?>后台管理系统</a></div>
  <div class="top_menu">
    <div class="login_info white">
                   您好！<?php echo Yii::app()->user->name ?> [<?php echo Yii::app()->user->getAdminRoleDescription()!=null?Yii::app()->user->getAdminRoleDescription():'最小权限管理员';?>]
      <span>|</span>
      <a href="<?php echo Yii::app()->createUrl('admin/default/logout')?>">[退出]</a>
      <span>|</span>
      <a href="<?php echo Yii::app()->createUrl('admin/default/index');?>">后台首页</a>
      <span>|</span>
      <a href="<?php echo Yii::app()->createUrl('site/index')?>" target="_blank">站点首页</a>
    </div>
    <ul class="top_menu_content white">
      <?php $n=1;?>
      <?php foreach ($top_menu as $k=>$m){?>
      <?php if($m['display']==1){?>
      <li class="top_menu <?php if($n==1){?>on<?php }?>" rel="<?php echo Yii::app()->createUrl('admin/default/leftMenu');?>" val="<?php echo $m['id']?>"><a class="cursor" style="outline:none;"><?php echo $m['name']?></a></li>
      <?php $n++;?>
      <?php }}?>
    </ul>
    <div class="help white">
      <a class="cursor" rel="lock_screen" url="<?php echo Yii::app()->createUrl('admin/default/lockscreen');?>"><img src="<?php echo Yii::app()->baseUrl;?>/images/admin/lockscreen.png" /> 锁屏</a>
      <span>|</span>
      <?php
      $this->widget('application.extensions.wl_artDialog.WLArtDialog',array(
          'title'=>'关于我们',
          'content'=>'关于我们',
          'url'=>Yii::app()->createUrl('admin/default/about'),
          'width'=>'500px',
          'height'=>'400px',
          'is_form'=>'0',
	  ));
      ?>
    </div>
  </div>
</div>
<div id="index_content">
  <div class="left_menu">
    <div class="left_main">
      <?php foreach ($init_left_menu as $k=>$v){?>
      <?php if($v['display']==1){?>
      <h3><span title="展开与收缩" class="cursor"></span><?php echo $v['name']?></h3>
      <?php if(isset($v['child_array'])){?>
      <ul>
        <?php foreach ($v['child_array'] as $k1=>$v1){?>
        <?php if(!empty($v1['data'])){?>
        <li><a href="<?php echo Yii::app()->createUrl($v1['m'].'/'.$v1['c'].'/'.$v1['a'],Util::param2array($v1['data']));?>" target="main"><?php echo $v1['name']?></a></li>
        <?php }else{?>
        <li><a href="<?php echo Yii::app()->createUrl($v1['m'].'/'.$v1['c'].'/'.$v1['a']);?>" target="main"><?php echo $v1['name']?></a></li>
        <?php }}?>     
      </ul>
      <?php }}}?>
    </div>
    <a title="展开与关闭" class="open cursor" rel="openClose">展开</a>
  </div>
  <div class="center_menu" style="display:none">
    <div class="center_menu_kuang">
      <div class="center_menu_content"><iframe name="center" id="center" marginheight="0" marginwidth="0" frameborder="0" scrolling="yes"  style="width:100%; height:100%; overflow-y:auto;overflow-x:hidden;position:absolute;top:0;bottom:0;"></iframe></div>
    </div>
  </div>
  <div class="right_content">
    <div class="crumbs">
      <p class="left" rel="breadcrumbs">当前位置：我的面板 &gt;</p>
      <p class="right">
        <a href="<?php echo Yii::app()->createUrl('admin/default/updateCache')?>" target="main"><span>更新缓存</span></a>
        <a href="#"><span>后台地图</span></a>
      </p>
    </div>
    <div class="content">
      <div class="content_iframe">
        <div class="iframe_content"><iframe name="main" id="main" marginheight="0" marginwidth="0" frameborder="0" scrolling="yes"  style="width:100%; height:100%; overflow-y:auto;overflow-x:hidden;position:absolute;top:0;bottom:0;" src="<?php echo Yii::app()->createUrl('admin/default/main')?>"></iframe></div>
        <div class="fav_nav">
          <div id="panellist">
            <?php foreach ($admin_panels as $url){?>
            <span>
              <a href="<?php echo $url->url;?>" target="main"><?php echo $url->name;?></a>
              <a class="panel_delete cursor" val="<?php echo $url->id?>" rel="<?php echo Yii::app()->createUrl('admin/default/PanelDel');?>"><em>删除</em></a>
            </span>
            <?php }?>
          </div>
          <div id="paneladd" style="display: none;">
            <a class="panel_add cursor" rel="<?php echo Yii::app()->createUrl('admin/default/PanelCreate');?>"><em>添加</em></a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
</body>
</html>