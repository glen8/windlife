<div id="main">
  <div class="col_border col_float col_width m_right_10">
    <h6>我的个人信息</h6>
    <div class="content">
      <p>您好，<?php echo Yii::app()->user->name; ?></p>
      <p>所属角色：<?php echo Yii::app()->user->getAdminRoleDescription()!=null?Yii::app()->user->getAdminRoleDescription():'最小权限管理员';?></p>
      <div class="hr"></div>
      <p>上次登录时间：<?php echo isset(Yii::app()->user->last_login)?Yii::app()->user->last_login:'首次登陆'; ?></p>
      <p>上次登录IP：<?php echo isset(Yii::app()->user->last_ip)?Yii::app()->user->last_ip:'首次登陆'; ?></p>
    </div>
  </div>
  <div class="col_border col_auto">
    <h6>系统信息</h6>
    <div class="content">
      <p>WindLife 系统版本：1.0 beta</p>
      <p>操作系统：<?php echo PHP_OS;?></p>
      <p>服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE'];?> & PHP <?php echo PHP_VERSION;?></p>
      <p>MySQL 版本：<?php echo Yii::app ()->db->serverVersion; ?></p>
      <p>上传文件：<?php echo $upload_size; ?></p>
    </div>
  </div>
  <div class="clear" style="height: 10px;"></div>
  <div class="col_border col_float col_width m_right_10">
    <h6>快捷方式</h6>
    <div class="content">
      <?php foreach ($admin_panels as $url){?>
      <span><a href="<?php echo $url->url; ?>">[<?php echo $url->name; ?>]</a></span>
      <?php }?>
    </div>
  </div>
  <div class="col_border col_auto">
    <h6>WindLife 系统开发团队</h6>
    <div class="content">
      <p>版权所有：windlife.net</p>
      <p>总策划：Glen </p>
      <p>开发与支持团队：Glen</p>
      <p>联系方式：QQ 402221480 / Email jsjgjf@qq.com</p>
      <p>官方网站：<a href="http://windlife.net" target="_blank">http://windlife.net</a></p>
    </div>
  </div>
</div>