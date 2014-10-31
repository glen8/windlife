<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/menu/listorder')); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">排序</th>
      <th width="100">id</th>
      <th>菜单名称</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
  <?php echo $menu_str;?>
  </tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
<?php echo CHtml::endForm(); ?>