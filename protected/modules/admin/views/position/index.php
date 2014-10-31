<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">编号</th>
      <th>位置引用key</th>
      <th>位置描述</th>
	  <th>内容/广告</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center" height="20"><?php echo $v->id;?></td>
      <td align="center"><?php echo $v->key_name;?></td>
      <td align="center"><?php echo $v->description;?></td>
      <td align="center"><?php echo !empty($v->type)?'广告':'内容';?></td>
      <td align="center">
        <?php echo CHtml::link('删除',array('/admin/position/delete',array('id'=>$v->id)),array('submit'=>array('/admin/position/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->description.' 』 吗？'))?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<?php echo CHtml::endForm(); ?>