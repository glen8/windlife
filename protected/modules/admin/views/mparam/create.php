<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<div id="search">
  <p class="text">当前为 “<?php echo $model_data['name']?>” 可配参数相关操作</p>
  <div class="clear"></div>
</div>
<?php $this->renderPartial('application.modules.admin.views._layouts.form', array('form'=>$form)); ?>
