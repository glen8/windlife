<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <p class="text">当前为版位 “<?php echo $position?>” 广告相关操作</p>
  <div class="clear"></div>
</div><?php $this->renderPartial('application.modules.admin.views._layouts.form', array('form'=>$form)); ?>