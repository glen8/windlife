<?php $this->renderPartial('application.modules.admin.views._layouts.sub_nav');?>
<?php echo CHtml::beginForm(Yii::app()->createUrl('admin/copyfrom/listorder')); ?>
<table width="100%" class="table_list">
  <thead>
    <tr>
      <th width="80">排序</th>
      <th width="100">来源名称</th>
      <th>来源连接</th>
      <th>来源logo</th>
      <th>是否默认</th>
	  <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($models as $v){?>
    <tr>
      <td align="center"><input name="listorders[<?php echo $v->id?>]" type="text" size="2" value="<?php echo $v->listorder?>" class="input-text-c input-text"></td>
      <td align="center"><?php echo $v->sitename;?></td>
      <td align="center"><?php echo $v->siteurl;?></td>
      <td align="center"><?php if(!empty($v->thumb)){?><img src="<?php echo $v->thumb;?>" /><?php }?></td>
      <td align="center"><?php echo $v->is_default==1?'是':'否';?></td>
      <td align="center">
        <a href="<?php echo Yii::app()->createUrl('admin/copyfrom/update',array('id'=>$v->id));?>">修改</a> |
        <?php echo CHtml::link('删除',array('/admin/copyfrom/delete',array('id'=>$v->id)),array('submit'=>array('/admin/copyfrom/delete','id'=>$v->id), 'confirm'=>'确定要删除 『 '.$v->sitename.' 』 吗？'))?>
      </td>
    </tr>
    <?php }?>
  </tbody>
</table>
<div class="btn"><input type="submit" class="button" name="dosubmit" value="排序" /></div>
<?php echo CHtml::endForm(); ?>